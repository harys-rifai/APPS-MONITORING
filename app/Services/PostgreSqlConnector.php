<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostgreSqlConnector
{
    private $connections = [];

    public function connect(array $config): \PDO
    {
        $key = $config['host'] . ':' . $config['port'] . ':' . $config['database'];
        
        if (isset($this->connections[$key])) {
            return $this->connections[$key];
        }

        try {
            $dsn = sprintf(
                'pgsql:host=%s;port=%d;dbname=%s',
                $config['host'],
                $config['port'],
                $config['database']
            );

            $pdo = new \PDO($dsn, $config['username'], $config['password'], [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);

            $this->connections[$key] = $pdo;
            return $pdo;
        } catch (\PDOException $e) {
            Log::error("PostgreSQL connection failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function getDatabaseStats(array $config): array
    {
        $pdo = $this->connect($config);
        
        $stats = [
            'active' => 0,
            'idle' => 0,
            'locked' => 0,
            'total' => 0,
        ];

        try {
            // Get active connections
            $stmt = $pdo->prepare("
                SELECT count(*) as count, state 
                FROM pg_stat_activity 
                WHERE datname = ?
                GROUP BY state
            ");
            $stmt->execute([$config['database']]);
            
            while ($row = $stmt->fetch()) {
                $state = $row['state'];
                $count = (int) $row['count'];
                
                if ($state === 'active') {
                    $stats['active'] = $count;
                } elseif ($state === 'idle') {
                    $stats['idle'] = $count;
                } elseif ($state === 'idle in transaction') {
                    $stats['locked'] = $count;
                }
                
                $stats['total'] += $count;
            }
        } catch (\Exception $e) {
            Log::error("Failed to get database stats: " . $e->getMessage());
        }

        return $stats;
    }

    public function getDatabaseInfo(array $config): array
    {
        $pdo = $this->connect($config);
        
        $info = [
            'version' => '',
            'size' => 0,
            'tables' => 0,
            'connections' => 0,
            'max_connections' => 0,
        ];

        try {
            // Get PostgreSQL version
            $stmt = $pdo->query("SELECT version()");
            $info['version'] = $stmt->fetch()['version'] ?? '';

            // Get database size
            $stmt = $pdo->prepare("SELECT pg_database_size(?) as size");
            $stmt->execute([$config['database']]);
            $info['size'] = (int) ($stmt->fetch()['size'] ?? 0);

            // Get number of tables
            $stmt = $pdo->query("
                SELECT count(*) as count 
                FROM pg_tables 
                WHERE schemaname = 'public'
            ");
            $info['tables'] = (int) ($stmt->fetch()['count'] ?? 0);

            // Get current connections for this database
            $stmt = $pdo->prepare("SELECT count(*) as count FROM pg_stat_activity WHERE datname = ?");
            $stmt->execute([$config['database']]);
            $info['connections'] = (int) ($stmt->fetch()['count'] ?? 0);

            // Get max connections
            $stmt = $pdo->query("SHOW max_connections");
            $info['max_connections'] = (int) ($stmt->fetch()['max_connections'] ?? 0);

        } catch (\Exception $e) {
            Log::error("Failed to get database info: " . $e->getMessage());
        }

        return $info;
    }

    public function getConnectionInfo(array $config): array
    {
        $pdo = $this->connect($config);
        
        $connections = [];

        try {
            $databaseName = $config['database'];
            $stmt = $pdo->prepare("
                SELECT 
                    pid,
                    usename as username,
                    application_name,
                    COALESCE(client_addr::text, 'local') as client_ip,
                    state,
                    COALESCE(query, 'idle') as query,
                    wait_event_type,
                    query_start,
                    state_change
                FROM pg_stat_activity 
                WHERE datname = ?
                ORDER BY 
                    CASE state 
                        WHEN 'active' THEN 1 
                        WHEN 'idle in transaction (aborted)' THEN 2 
                        WHEN 'idle in transaction' THEN 3 
                        WHEN 'idle' THEN 4 
                        ELSE 5 
                    END,
                    query_start DESC
                LIMIT 50
            ");
            $stmt->execute([$databaseName]);

            while ($row = $stmt->fetch()) {
                $queryStart = $row['query_start'] ? new \DateTime($row['query_start']) : null;
                $duration = '-';
                if ($queryStart) {
                    $now = new \DateTime();
                    $diff = $now->getTimestamp() - $queryStart->getTimestamp();
                    if ($diff < 60) {
                        $duration = $diff . 's';
                    } elseif ($diff < 3600) {
                        $duration = floor($diff / 60) . 'm';
                    } else {
                        $duration = floor($diff / 3600) . 'h';
                    }
                }

                $connections[] = [
                    'pid' => $row['pid'],
                    'username' => $row['username'],
                    'application_name' => $row['application_name'] ?: '-',
                    'client_ip' => $row['client_ip'],
                    'state' => $row['state'] ?: 'unknown',
                    'query' => $row['query'] ? substr($row['query'], 0, 150) : ($row['state'] === 'idle' ? 'waiting for query' : '-'),
                    'wait_event_type' => $row['wait_event_type'] ?: '-',
                    'query_start' => $row['query_start'] ? date('H:i:s', strtotime($row['query_start'])) : '-',
                    'duration' => $duration,
                ];
            }
        } catch (\Exception $e) {
            Log::error("Failed to get connection info: " . $e->getMessage());
        }

        return $connections;
    }

    public function getTableStats(array $config): array
    {
        $pdo = $this->connect($config);
        
        $tables = [];

        try {
            $stmt = $pdo->query("
                SELECT 
                    schemaname,
                    tablename,
                    pg_total_relation_size(schemaname||'.'||tablename) as total_size_bytes,
                    pg_relation_size(schemaname||'.'||tablename) as table_size_bytes,
                    pg_indexes_size(schemaname||'.'||tablename) as index_size_bytes
                FROM pg_tables
                WHERE schemaname = 'public'
                ORDER BY pg_total_relation_size(schemaname||'.'||tablename) DESC
                LIMIT 30
            ");

            $n = 1;
            while ($row = $stmt->fetch()) {
                $tables[] = [
                    'n' => $n,
                    'name' => $row['tablename'],
                    'schema' => $row['schemaname'],
                    'total_size' => $this->formatBytes($row['total_size_bytes']),
                    'total_size_bytes' => (int) $row['total_size_bytes'],
                    'table_size' => $this->formatBytes($row['table_size_bytes']),
                    'table_size_bytes' => (int) $row['table_size_bytes'],
                    'index_size' => $this->formatBytes($row['index_size_bytes']),
                    'index_size_bytes' => (int) $row['index_size_bytes'],
                ];
                $n++;
            }
        } catch (\Exception $e) {
            Log::error("Failed to get table stats: " . $e->getMessage());
        }

        return $tables;
    }

    public function testConnection(array $config): bool
    {
        try {
            $this->connect($config);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes === 0) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
