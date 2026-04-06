<?php

namespace App\Http\Livewire;

use App\Models\Database;
use App\Models\Corporate;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DatabaseList extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $databaseId = null;
    public $server_id = null;
    public $corporate_id = null;
    public $name = '';
    public $type = 'postgres';
    public $connection_name = '';
    public $host = '';
    public $port = 5432;
    public $username = '';
    public $password = '';
    public $database = '';
    public $active_threshold = 50;
    public $idle_threshold = 100;
    public $lock_threshold = 10;
    public $is_active = true;
    public $search = '';
    public $viewDatabase = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|in:postgres,mysql,sqlserver,db2,oracle',
        'host' => 'required|string|max:255',
        'port' => 'required|integer',
        'active_threshold' => 'required|integer|min:1',
        'idle_threshold' => 'required|integer|min:1',
        'lock_threshold' => 'required|integer|min:0',
    ];

    public function render()
    {
        $user = Auth::user();
        $corporateId = $user ? $user->corporate_id : null;
        
        $databases = Database::with('server')
            ->whereRaw('is_active = true')
            ->when($corporateId, function($query) use ($corporateId) {
                return $query->where('corporate_id', $corporateId);
            })
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('host', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        return view('livewire.database-list', compact('databases'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $db = Database::whereRaw('is_active = true')->find($id);
            $this->databaseId = $db->id;
            $this->server_id = $db->server_id;
            $this->corporate_id = $db->corporate_id;
            $this->name = $db->name;
            $this->type = $db->type;
            $this->connection_name = $db->connection_name ?? '';
            $this->host = $db->host;
            $this->port = $db->port;
            $this->username = $db->username ?? '';
            $this->password = $db->password ?? '';
            $this->database = $db->database ?? '';
            $this->active_threshold = $db->active_threshold;
            $this->idle_threshold = $db->idle_threshold;
            $this->lock_threshold = $db->lock_threshold;
            $this->is_active = $db->is_active;
        } else {
            $this->resetFields();
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFields();
    }

    public function viewDatabase($id)
    {
        $db = Database::with('server')->whereRaw('is_active = true')->find($id);
        if ($db) {
            $this->viewDatabase = $db;
            $this->showViewModal = true;
        }
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewDatabase = null;
    }

    public function resetFields()
    {
        $this->databaseId = null;
        $this->server_id = null;
        $this->corporate_id = null;
        $this->name = '';
        $this->type = 'postgres';
        $this->connection_name = '';
        $this->host = '';
        $this->port = 5432;
        $this->username = '';
        $this->password = '';
        $this->database = '';
        $this->active_threshold = 50;
        $this->idle_threshold = 100;
        $this->lock_threshold = 10;
        $this->is_active = true;
    }

    public function save()
    {
        $this->validate();
        
        $connectionName = $this->connection_name ?: 'db_' . time();

        if ($this->databaseId) {
            Database::find($this->databaseId)->update([
                'server_id' => $this->server_id,
                'name' => $this->name,
                'type' => $this->type,
                'connection_name' => $connectionName,
                'host' => $this->host,
                'port' => $this->port,
                'username' => $this->username,
                'password' => $this->password,
                'database' => $this->database,
                'active_threshold' => $this->active_threshold,
                'idle_threshold' => $this->idle_threshold,
                'lock_threshold' => $this->lock_threshold,
                'is_active' => $this->is_active,
                'corporate_id' => $this->corporate_id,
            ]);
        } else {
            Database::create([
                'server_id' => $this->server_id,
                'name' => $this->name,
                'type' => $this->type,
                'connection_name' => $connectionName,
                'host' => $this->host,
                'port' => $this->port,
                'username' => $this->username,
                'password' => $this->password,
                'database' => $this->database,
                'active_threshold' => $this->active_threshold,
                'idle_threshold' => $this->idle_threshold,
                'lock_threshold' => $this->lock_threshold,
                'is_active' => $this->is_active,
                'corporate_id' => $this->corporate_id,
            ]);
        }

        $this->closeModal();
        session()->flash('message', 'Database saved successfully!');
    }

    public function delete($id)
    {
        Database::find($id)->delete();
        session()->flash('message', 'Database deleted successfully!');
    }

    public function confirmDelete($id)
    {
        $this->databaseId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->databaseId = null;
        $this->showDeleteModal = false;
    }

    public function executeDelete()
    {
        if ($this->databaseId) {
            Database::find($this->databaseId)->delete();
            session()->flash('message', 'Database deleted successfully!');
        }
        $this->cancelDelete();
    }
}