<?php

namespace App\Http\Livewire;

use App\Models\Database;
use App\Services\PostgreSqlConnector;
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
    
    public $connectionsPage = 1;
    public $tablesPage = 1;
    public $perPage = 10;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->databaseId = request()->route('id');
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
            'host' => $this->database->host,
            'port' => $this->database->port,
            'database' => $this->database->database,
            'username' => $this->database->username,
            'password' => $this->database->password,
        ];

        try {
            $connector = new PostgreSqlConnector();
            
            $this->stats = $connector->getDatabaseStats($config);
            $this->info = $connector->getDatabaseInfo($config);
            $this->connections = $connector->getConnectionInfo($config);
            $this->tables = $connector->getTableStats($config);
            $this->isConnected = true;
            $this->error = null;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->isConnected = false;
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
