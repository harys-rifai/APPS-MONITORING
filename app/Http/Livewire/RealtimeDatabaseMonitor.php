<?php

namespace App\Http\Livewire;

use App\Models\Database;
use App\Services\DatabaseConnector;
use Livewire\Component;

class RealtimeDatabaseMonitor extends Component
{
    public $databaseId = null;
    public $database;
    public $stats = [];
    public $info = [];
    public $connections = [];
    public $tables = [];
    public $error = null;
    public $isConnected = false;
    public $refreshInterval = 5000;
    public $startTime;
    public $uptime = '';
    
    public $connectionsPage = 1;
    public $tablesPage = 1;
    public $perPage = 10;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->databaseId = request()->route('id');
        $this->startTime = time();
        if ($this->databaseId) {
            $this->loadData();
        }
    }
    public function loadData()
    {
        $this->database = Database::find($this->databaseId);
        
        if (!$this->database) {
            $this->error = 'Database not found';
            return;
        }

        $config = [
            'type' => $this->database->type,
            'host' => $this->database->host,
            'port' => $this->database->port,
            'database' => $this->database->database,
            'username' => $this->database->username,
            'password' => $this->database->password,
        ];

        try {
            $connector = new DatabaseConnector();
            
            // Validate driver first
            $this->stats = $connector->getDatabaseStats($config);
            $this->info = $connector->getDatabaseInfo($config);
            $this->connections = $connector->getConnectionInfo($config);
            $this->tables = $connector->getTableStats($config);
            $this->isConnected = true;
            $this->error = null;
            $this->uptime = $this->calculateUptime();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            if (str_contains($this->error, 'could not find driver') || str_contains($this->error, 'Driver for')) {
                $this->error = "🔌 Driver Missing: " . $this->error . " Please enable the required extension in your php.ini and restart Laragon.";
            } elseif (str_contains($this->error, 'Connection refused')) {
                $this->error = "🚫 Connection Refused: The database server at {$this->database->host}:{$this->database->port} is not responding. Please check if the server is running and remote access is enabled.";
            }
            $this->isConnected = false;
        }
    }

    private function calculateUptime(): string
    {
        $diff = time() - $this->startTime;
        
        if ($diff < 60) {
            return $diff . 's';
        } elseif ($diff < 3600) {
            return floor($diff / 60) . 'm ' . ($diff % 60) . 's';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            $mins = floor(($diff % 3600) / 60);
            return $hours . 'h ' . $mins . 'm';
        } else {
            $days = floor($diff / 86400);
            $hours = floor(($diff % 86400) / 3600);
            return $days . 'd ' . $hours . 'h';
        }
    }

    public function getPaginatedConnections()
    {
        return array_slice($this->connections, ($this->connectionsPage - 1) * $this->perPage, $this->perPage);
    }

    public function getPaginatedTables()
    {
        return array_slice($this->tables, ($this->tablesPage - 1) * $this->perPage, $this->perPage);
    }

    public function getTotalConnectionsPages()
    {
        return (int) ceil(count($this->connections) / $this->perPage);
    }

    public function getTotalTablesPages()
    {
        return (int) ceil(count($this->tables) / $this->perPage);
    }

    public function render()
    {
        return view('livewire.realtime-database-monitor');
    }
}
