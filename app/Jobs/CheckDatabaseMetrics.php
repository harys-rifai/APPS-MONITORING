<?php

namespace App\Jobs;

use App\Events\DatabaseRecovered;
use App\Events\DatabaseSpikeDetected;
use App\Models\Database as Db;
use App\Models\DbMetric;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB as Database;
use Illuminate\Support\Facades\Log;

class CheckDatabaseMetrics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $databases = Db::whereRaw('is_active = true')->get();

        foreach ($databases as $db) {
            try {
                $metrics = $this->fetchDbMetrics($db);

                DbMetric::create([
                    'database_id' => $db->id,
                    'active_count' => $metrics['active'],
                    'idle_count' => $metrics['idle'],
                    'locked_count' => $metrics['locked'],
                ]);

                $this->checkThresholds($db, $metrics);
            } catch (\Exception $e) {
                Log::error("Failed to check database metrics for {$db->name}: " . $e->getMessage());
            }
        }
    }

    private function fetchDbMetrics($db): array
    {
        $metrics = ['active' => 0, 'idle' => 0, 'locked' => 0];

        try {
            config(["database.connections.{$db->connection_name}" => [
                'driver' => $db->type,
                'host' => $db->host,
                'port' => $db->port,
                'database' => $db->database,
                'username' => $db->username,
                'password' => $db->password,
            ]]);

            switch ($db->type) {
                case 'postgres':
                    $metrics = $this->fetchPostgresMetrics($db);
                    break;
                case 'mysql':
                    $metrics = $this->fetchMysqlMetrics($db);
                    break;
                case 'sqlserver':
                    $metrics = $this->fetchSqlServerMetrics($db);
                    break;
                case 'db2':
                    $metrics = $this->fetchDb2Metrics($db);
                    break;
                case 'oracle':
                    $metrics = $this->fetchOracleMetrics($db);
                    break;
                default:
                    Log::warning("Unknown database type: {$db->type}");
            }
        } catch (\Exception $e) {
            Log::error("Database connection failed for {$db->name}: " . $e->getMessage());
        }

        return $metrics;
    }

    private function fetchPostgresMetrics($db): array
    {
        $results = Database::connection($db->connection_name)
            ->select("SELECT state, COUNT(*) as count FROM pg_stat_activity GROUP BY state");

        $metrics = ['active' => 0, 'idle' => 0, 'locked' => 0];
        foreach ($results as $row) {
            $state = strtolower($row->state ?? 'idle');
            if (in_array($state, ['active', 'running'])) {
                $metrics['active'] = (int) $row->count;
            } elseif (in_array($state, ['idle', 'idle in transaction'])) {
                $metrics['idle'] = (int) $row->count;
            } else {
                $metrics['locked'] += (int) $row->count;
            }
        }
        return $metrics;
    }

    private function fetchMysqlMetrics($db): array
    {
        $results = Database::connection($db->connection_name)
            ->select("SHOW PROCESSLIST");

        $metrics = ['active' => 0, 'idle' => 0, 'locked' => 0];
        foreach ($results as $row) {
            $state = strtolower($row->Command ?? 'Sleep');
            if (in_array($state, ['query', 'execute'])) {
                $metrics['active']++;
            } elseif ($state === 'sleep') {
                $metrics['idle']++;
            } else {
                $metrics['locked']++;
            }
        }
        return $metrics;
    }

    private function fetchSqlServerMetrics($db): array
    {
        $results = Database::connection($db->connection_name)
            ->select("SELECT status, COUNT(*) as count FROM sys.dm_exec_sessions GROUP BY status");

        $metrics = ['active' => 0, 'idle' => 0, 'locked' => 0];
        foreach ($results as $row) {
            $status = strtolower($row->status ?? 'running');
            if ($status === 'running') {
                $metrics['active'] = (int) $row->count;
            } elseif ($status === 'sleeping') {
                $metrics['idle'] = (int) $row->count;
            } else {
                $metrics['locked'] += (int) $row->count;
            }
        }
        return $metrics;
    }

    private function fetchDb2Metrics($db): array
    {
        $results = Database::connection($db->connection_name)
            ->select("SELECT STATE, COUNT(*) as count FROM SYSIBMADM.ACTIVE_CONSumerS GROUP BY STATE");

        $metrics = ['active' => 0, 'idle' => 0, 'locked' => 0];
        foreach ($results as $row) {
            $state = strtolower($row->STATE ?? 'active');
            if ($state === 'active') {
                $metrics['active'] = (int) $row->count;
            } elseif ($state === 'idle') {
                $metrics['idle'] = (int) $row->count;
            } else {
                $metrics['locked'] += (int) $row->count;
            }
        }
        return $metrics;
    }

    private function fetchOracleMetrics($db): array
    {
        $results = Database::connection($db->connection_name)
            ->select("SELECT STATUS, COUNT(*) as count FROM V\$SESSION GROUP BY STATUS");

        $metrics = ['active' => 0, 'idle' => 0, 'locked' => 0];
        foreach ($results as $row) {
            $status = strtolower($row->STATUS ?? 'active');
            if ($status === 'active') {
                $metrics['active'] = (int) $row->count;
            } elseif (in_array($status, ['inactive', 'sniped'])) {
                $metrics['idle'] = (int) $row->count;
            } else {
                $metrics['locked'] += (int) $row->count;
            }
        }
        return $metrics;
    }

    private function checkThresholds($db, array $metrics): void
    {
        $activeSpike = $metrics['active'] > $db->active_threshold;
        $idleSpike = $metrics['idle'] > $db->idle_threshold;
        $lockedSpike = $metrics['locked'] > $db->lock_threshold;

        $isSpiking = $activeSpike || $lockedSpike;

        if ($isSpiking && $db->status !== 'spike') {
            $db->update(['status' => 'spike']);
            event(new DatabaseSpikeDetected($db, $metrics));
        } elseif (!$isSpiking && $db->status === 'spike') {
            $db->update(['status' => 'ok']);
            event(new DatabaseRecovered($db, $metrics));
        }
    }
}