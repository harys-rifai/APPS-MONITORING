<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseConnector
{
    private $connections = [];

    public function connect(array $config): \PDO
    {
        $type = $config['type'] ?? 'pgsql';
        $key = $type . ':' . $config['host'] . ':' . $config['port'] . ':' . $config['database'];
        
        if (isset($this->connections[$key])) {
            return $this->connections[$key];
        }

        try {
            $dsn = '';
            switch ($type) {
                case 'mysql':
                    $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s', $config['host'], $config['port'], $config['database']);
                    break;
                case 'oracle':
                case 'oci':
                    $dsn = sprintf('oci:dbname=//%s:%d/%s', $config['host'], $config['port'], $config['database']);
                    break;
                case 'edb':
                case 'pgsql':
                default:
                    $dsn = sprintf('pgsql:host=%s;port=%d;dbname=%s', $config['host'], $config['port'], $config['database']);
                    break;
                case 'sqlserver':
                case 'sqlsrv':
                    // On Windows use sqlsrv, on Linux use dblib
                    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                        $dsn = sprintf('sqlsrv:Server=%s,%d;Database=%s', $config['host'], $config['port'], $config['database']);
                    } else {
                        $dsn = sprintf('dblib:host=%s:%d;dbname=%s', $config['host'], $config['port'], $config['database']);
                    }
                    break;
            }

            // Check if driver is installed before attempting connection
            $driver = explode(':', $dsn)[0];
            if (!in_array($driver, \PDO::getAvailableDrivers())) {
                throw new \Exception("PHP Driver for '{$driver}' is not installed. Please enable it in your php.ini.");
            }

            $pdo = new \PDO($dsn, $config['username'], $config['password'], [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_TIMEOUT => 5, // Timeout after 5 seconds
            ]);

            $this->connections[$key] = $pdo;
            return $pdo;
        } catch (\PDOException $e) {
            Log::error("Database connection failed ({$type}): " . $e->getMessage());
            throw $e;
        }
    }

    public function getDatabaseStats(array $config): array
    {
        $pdo = $this->connect($config);
        $type = $config['type'] ?? 'pgsql';
        
        $stats = [
            'active' => 0,
            'idle' => 0,
            'locked' => 0,
            'total' => 0,
        ];

        try {
            if ($type === 'pgsql' || $type === 'postgres' || $type === 'edb') {
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
            } elseif ($type === 'mysql') {
                $stmt = $pdo->query("
                    SELECT 
                        SUM(CASE WHEN command != 'Sleep' THEN 1 ELSE 0 END) as active,
                        SUM(CASE WHEN command = 'Sleep' THEN 1 ELSE 0 END) as idle,
                        COUNT(*) as total
                    FROM information_schema.processlist
                ");
                $result = $stmt->fetch();
                if ($result) {
                    $stats['active'] = (int) ($result['active'] ?? 0);
                    $stats['idle'] = (int) ($result['idle'] ?? 0);
                    $stats['total'] = (int) ($result['total'] ?? 0);
                }
            } elseif ($type === 'sqlserver' || $type === 'sqlsrv') {
                $stmt = $pdo->query("
                    SELECT 
                        SUM(CASE WHEN status = 'runnable' THEN 1 ELSE 0 END) as active,
                        SUM(CASE WHEN status = 'sleeping' THEN 1 ELSE 0 END) as idle,
                        SUM(CASE WHEN status = 'suspended' THEN 1 ELSE 0 END) as locked,
                        COUNT(*) as total
                    FROM sys.sysprocesses
                    WHERE dbid = DB_ID()
                ");
                $result = $stmt->fetch();
                if ($result) {
                    $stats['active'] = (int) ($result['active'] ?? 0);
                    $stats['idle'] = (int) ($result['idle'] ?? 0);
                    $stats['locked'] = (int) ($result['locked'] ?? 0);
                    $stats['total'] = (int) ($result['total'] ?? 0);
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to get database stats ({$type}): " . $e->getMessage());
        }

        return $stats;
    }

    public function getDatabaseInfo(array $config): array
    {
        $pdo = $this->connect($config);
        $type = $config['type'] ?? 'pgsql';
        
        $info = [
            'version' => '',
            'size' => 0,
            'tables' => 0,
            'connections' => 0,
            'max_connections' => 0,
        ];

        try {
            if ($type === 'pgsql' || $type === 'postgres' || $type === 'edb') {
                $stmt = $pdo->query("SELECT version()");
                $info['version'] = $stmt->fetch()['version'] ?? '';

                $stmt = $pdo->prepare("SELECT pg_database_size(?) as size");
                $stmt->execute([$config['database']]);
                $info['size'] = (int) ($stmt->fetch()['size'] ?? 0);

                $stmt = $pdo->query("SELECT count(*) as count FROM pg_tables WHERE schemaname = 'public'");
                $info['tables'] = (int) ($stmt->fetch()['count'] ?? 0);

                $stmt = $pdo->prepare("SELECT count(*) as count FROM pg_stat_activity WHERE datname = ?");
                $stmt->execute([$config['database']]);
                $info['connections'] = (int) ($stmt->fetch()['count'] ?? 0);

                $stmt = $pdo->query("SHOW max_connections");
                $info['max_connections'] = (int) ($stmt->fetch()['max_connections'] ?? 0);
            } elseif ($type === 'mysql') {
                $stmt = $pdo->query("SELECT VERSION() as version");
                $info['version'] = $stmt->fetch()['version'] ?? '';

                $stmt = $pdo->prepare("
                    SELECT SUM(data_length + index_length) as size 
                    FROM information_schema.tables 
                    WHERE table_schema = ?
                ");
                $stmt->execute([$config['database']]);
                $info['size'] = (int) ($stmt->fetch()['size'] ?? 0);

                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ?");
                $stmt->execute([$config['database']]);
                $info['tables'] = (int) ($stmt->fetch()['count'] ?? 0);

                $stmt = $pdo->query("SELECT COUNT(*) as count FROM information_schema.processlist");
                $info['connections'] = (int) ($stmt->fetch()['count'] ?? 0);

                $stmt = $pdo->query("SHOW VARIABLES LIKE 'max_connections'");
                $info['max_connections'] = (int) ($stmt->fetch()['Value'] ?? 0);
            } elseif ($type === 'sqlserver' || $type === 'sqlsrv') {
                $stmt = $pdo->query("SELECT @@VERSION as version");
                $info['version'] = $stmt->fetch()['version'] ?? '';

                $stmt = $pdo->query("SELECT SUM(size) * 8 * 1024 as size FROM sys.master_files WHERE database_id = DB_ID()");
                $info['size'] = (int) ($stmt->fetch()['size'] ?? 0);

                $stmt = $pdo->query("SELECT COUNT(*) as count FROM sys.tables");
                $info['tables'] = (int) ($stmt->fetch()['count'] ?? 0);

                $stmt = $pdo->query("SELECT COUNT(*) as count FROM sys.sysprocesses WHERE dbid = DB_ID()");
                $info['connections'] = (int) ($stmt->fetch()['count'] ?? 0);

                $stmt = $pdo->query("SELECT @@MAX_CONNECTIONS as max_connections");
                $info['max_connections'] = (int) ($stmt->fetch()['max_connections'] ?? 0);
            }

        } catch (\Exception $e) {
            Log::error("Failed to get database info ({$type}): " . $e->getMessage());
        }

        return $info;
    }

    public function getConnectionInfo(array $config): array
    {
        $pdo = $this->connect($config);
        $type = $config['type'] ?? 'pgsql';
        $connections = [];

        try {
            if ($type === 'pgsql' || $type === 'postgres' || $type === 'edb') {
                $stmt = $pdo->prepare("
                    SELECT 
                        pid, usename as username, application_name,
                        COALESCE(client_addr::text, 'local') as client_ip,
                        state, COALESCE(query, 'idle') as query,
                        wait_event_type, query_start
                    FROM pg_stat_activity 
                    WHERE datname = ?
                    ORDER BY query_start DESC
                    LIMIT 50
                ");
                $stmt->execute([$config['database']]);

                while ($row = $stmt->fetch()) {
                    $connections[] = [
                        'pid' => $row['pid'],
                        'username' => $row['username'],
                        'application_name' => $row['application_name'] ?: '-',
                        'client_ip' => $row['client_ip'],
                        'state' => $row['state'] ?: 'unknown',
                        'query' => $row['query'] ? substr($row['query'], 0, 150) : '-',
                        'duration' => $this->calculateDuration($row['query_start']),
                    ];
                }
            } elseif ($type === 'mysql') {
                $stmt = $pdo->query("SELECT * FROM information_schema.processlist ORDER BY time DESC LIMIT 50");
                while ($row = $stmt->fetch()) {
                    $connections[] = [
                        'pid' => $row['ID'],
                        'username' => $row['USER'],
                        'application_name' => '-',
                        'client_ip' => $row['HOST'],
                        'state' => $row['COMMAND'],
                        'query' => $row['INFO'] ? substr($row['INFO'], 0, 150) : '-',
                        'duration' => $row['TIME'] . 's',
                    ];
                }
            } elseif ($type === 'sqlserver' || $type === 'sqlsrv') {
                $stmt = $pdo->query("
                    SELECT 
                        spid as pid, loginame as username, program_name as application_name,
                        hostname as client_ip, status as state, cmd as query,
                        login_time as query_start
                    FROM sys.sysprocesses
                    WHERE dbid = DB_ID()
                    ORDER BY login_time DESC
                ");

                while ($row = $stmt->fetch()) {
                    $connections[] = [
                        'pid' => $row['pid'],
                        'username' => trim($row['username']),
                        'application_name' => trim($row['application_name']) ?: '-',
                        'client_ip' => trim($row['client_ip']),
                        'state' => trim($row['state']),
                        'query' => trim($row['query']),
                        'duration' => $this->calculateDuration($row['query_start']),
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to get connection info ({$type}): " . $e->getMessage());
        }

        return $connections;
    }

    private function calculateDuration($startTime): string
    {
        if (!$startTime) return '-';
        try {
            $start = new \DateTime($startTime);
            $diff = time() - $start->getTimestamp();
            if ($diff < 60) return $diff . 's';
            if ($diff < 3600) return floor($diff / 60) . 'm';
            return floor($diff / 3600) . 'h';
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function getTableStats(array $config): array
    {
        $pdo = $this->connect($config);
        $type = $config['type'] ?? 'pgsql';
        $tables = [];

        try {
            if ($type === 'pgsql' || $type === 'postgres' || $type === 'edb') {
                $stmt = $pdo->query("
                    SELECT schemaname, tablename,
                        pg_relation_size(schemaname||'.'||tablename) as table_size_bytes,
                        pg_indexes_size(schemaname||'.'||tablename) as index_size_bytes,
                        pg_total_relation_size(schemaname||'.'||tablename) as total_size_bytes
                    FROM pg_tables
                    WHERE schemaname = 'public'
                    ORDER BY total_size_bytes DESC
                    LIMIT 30
                ");

                $n = 1;
                while ($row = $stmt->fetch()) {
                    $tables[] = [
                        'n' => $n++,
                        'name' => $row['tablename'],
                        'schema' => $row['schemaname'],
                        'table_size' => $this->formatBytes($row['table_size_bytes']),
                        'index_size' => $this->formatBytes($row['index_size_bytes']),
                        'total_size' => $this->formatBytes($row['total_size_bytes']),
                    ];
                }
            } elseif ($type === 'mysql') {
                $stmt = $pdo->prepare("
                    SELECT 
                        table_name as tablename,
                        table_schema as schemaname,
                        (data_length + index_length) as total_size_bytes
                    FROM information_schema.tables 
                    WHERE table_schema = ?
                    ORDER BY total_size_bytes DESC
                    LIMIT 30
                ");
                $stmt->execute([$config['database']]);

                $n = 1;
                while ($row = $stmt->fetch()) {
                    $tables[] = [
                        'n' => $n++,
                        'name' => $row['tablename'],
                        'schema' => $row['schemaname'],
                        'total_size' => $this->formatBytes($row['total_size_bytes']),
                    ];
                }
            } elseif ($type === 'sqlserver' || $type === 'sqlsrv') {
                $stmt = $pdo->query("
                    SELECT 
                        t.name AS tablename,
                        s.name AS schemaname,
                        SUM(a.total_pages) * 8 * 1024 AS total_size_bytes
                    FROM sys.tables t
                    INNER JOIN sys.schemas s ON t.schema_id = s.schema_id
                    INNER JOIN sys.indexes i ON t.object_id = i.object_id
                    INNER JOIN sys.partitions p ON i.object_id = p.object_id AND i.index_id = p.index_id
                    INNER JOIN sys.allocation_units a ON p.partition_id = a.container_id
                    GROUP BY t.name, s.name
                    ORDER BY total_size_bytes DESC
                ");

                $n = 1;
                while ($row = $stmt->fetch()) {
                    $tables[] = [
                        'n' => $n++,
                        'name' => $row['tablename'],
                        'schema' => $row['schemaname'],
                        'total_size' => $this->formatBytes($row['total_size_bytes']),
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to get table stats ({$type}): " . $e->getMessage());
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
