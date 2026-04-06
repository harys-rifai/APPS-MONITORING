<?php

namespace App\Jobs;

use App\Models\Server;
use App\Models\Database as Db;
use App\Models\ServerMetric;
use App\Models\DbMetric;
use App\Models\Alert;
use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB as FacadeDB;

class SyncToStaging implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $this->syncRoles();
        $this->syncServers();
        $this->syncDatabases();
        $this->syncServerMetrics();
        $this->syncDbMetrics();
        $this->syncAlerts();
        
        Log::info('Sync to staging completed');
    }

    private function syncRoles(): void
    {
        $mainRoles = FacadeDB::connection('pgsql')->table('roles')->get();
        $staging = FacadeDB::connection('pgsql_staging')->table('roles');

        $data = $mainRoles->map(fn($role) => [
            'id' => $role->id,
            'name' => $role->name,
            'created_at' => $role->created_at,
            'updated_at' => $role->updated_at,
        ])->toArray();

        $staging->upsert($data, ['id'], ['name', 'updated_at']);
        Log::info("Synced {$mainRoles->count()} roles");
    }

    private function syncServers(): void
    {
        $mainServers = Server::whereRaw('is_active = true')->get();
        $staging = FacadeDB::connection('pgsql_staging')->table('servers');

        $data = $mainServers->map(fn($server) => [
            'id' => $server->id,
            'name' => $server->name,
            'hostname' => $server->hostname,
            'ip' => $server->ip,
            'os' => $server->os,
            'type' => $server->type,
            'cpu_threshold' => $server->cpu_threshold,
            'ram_threshold' => $server->ram_threshold,
            'disk_threshold' => $server->disk_threshold,
            'network_threshold' => $server->network_threshold,
            'location' => $server->location,
            'api_token' => $server->api_token,
            'is_active' => $server->is_active,
            'role_id' => $server->role_id,
            'status' => $server->status,
            'created_at' => $server->created_at,
            'updated_at' => $server->updated_at,
        ])->toArray();

        $staging->upsert($data, ['id'], ['name', 'hostname', 'ip', 'os', 'type', 'cpu_threshold', 'ram_threshold', 'disk_threshold', 'network_threshold', 'location', 'api_token', 'is_active', 'role_id', 'status', 'updated_at']);
        Log::info("Synced {$mainServers->count()} servers");
    }

    private function syncDatabases(): void
    {
        $mainDbs = Db::whereRaw('is_active = true')->get();
        $staging = FacadeDB::connection('pgsql_staging')->table('databases');

        $data = $mainDbs->map(fn($db) => [
            'id' => $db->id,
            'server_id' => $db->server_id,
            'name' => $db->name,
            'type' => $db->type,
            'connection_name' => $db->connection_name,
            'host' => $db->host,
            'port' => $db->port,
            'username' => $db->username,
            'password' => $db->password,
            'database' => $db->database,
            'active_threshold' => $db->active_threshold,
            'idle_threshold' => $db->idle_threshold,
            'lock_threshold' => $db->lock_threshold,
            'status' => $db->status,
            'is_active' => $db->is_active,
            'role_id' => $db->role_id,
            'created_at' => $db->created_at,
            'updated_at' => $db->updated_at,
        ])->toArray();

        $staging->upsert($data, ['id'], ['server_id', 'name', 'type', 'connection_name', 'host', 'port', 'username', 'password', 'database', 'active_threshold', 'idle_threshold', 'lock_threshold', 'status', 'is_active', 'role_id', 'updated_at']);
        Log::info("Synced {$mainDbs->count()} databases");
    }

    private function syncServerMetrics(): void
    {
        $mainMetrics = FacadeDB::connection('pgsql')
            ->table('server_metrics')
            ->where('created_at', '>=', now()->subHours(24))
            ->get();
        
        $staging = FacadeDB::connection('pgsql_staging')->table('server_metrics');

        $data = $mainMetrics->map(fn($metric) => [
            'id' => $metric->id,
            'server_id' => $metric->server_id,
            'cpu' => $metric->cpu,
            'ram' => $metric->ram,
            'disk' => $metric->disk,
            'network_in' => $metric->network_in,
            'network_out' => $metric->network_out,
            'created_at' => $metric->created_at,
            'updated_at' => $metric->updated_at,
        ])->toArray();

        $staging->upsert($data, ['id'], ['server_id', 'cpu', 'ram', 'disk', 'network_in', 'network_out', 'updated_at']);
        Log::info("Synced {$mainMetrics->count()} server metrics");
    }

    private function syncDbMetrics(): void
    {
        $mainMetrics = FacadeDB::connection('pgsql')
            ->table('db_metrics')
            ->where('created_at', '>=', now()->subHours(24))
            ->get();
        
        $staging = FacadeDB::connection('pgsql_staging')->table('db_metrics');

        $data = $mainMetrics->map(fn($metric) => [
            'id' => $metric->id,
            'database_id' => $metric->database_id,
            'active_count' => $metric->active_count,
            'idle_count' => $metric->idle_count,
            'locked_count' => $metric->locked_count,
            'created_at' => $metric->created_at,
            'updated_at' => $metric->updated_at,
        ])->toArray();

        $staging->upsert($data, ['id'], ['database_id', 'active_count', 'idle_count', 'locked_count', 'updated_at']);
        Log::info("Synced {$mainMetrics->count()} db metrics");
    }

    private function syncAlerts(): void
    {
        $mainAlerts = FacadeDB::connection('pgsql')
            ->table('alerts')
            ->where('created_at', '>=', now()->subDays(7))
            ->get();
        
        $staging = FacadeDB::connection('pgsql_staging')->table('alerts');

        $data = $mainAlerts->map(fn($alert) => [
            'id' => $alert->id,
            'alertable_type' => $alert->alertable_type,
            'alertable_id' => $alert->alertable_id,
            'type' => $alert->type,
            'message' => $alert->message,
            'data' => $alert->data,
            'created_at' => $alert->created_at,
            'updated_at' => $alert->updated_at,
        ])->toArray();

        $staging->upsert($data, ['id'], ['alertable_type', 'alertable_id', 'type', 'message', 'data', 'updated_at']);
        Log::info("Synced {$mainAlerts->count()} alerts");
    }
}