<?php

namespace App\Http\Livewire;

use App\Models\Organisation;
use App\Models\Server;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ServerList extends Component
{
    use WithPagination;

    public $showModal = false;

    public $showViewModal = false;

    public $showDeleteModal = false;

    public $serverId = null;

    public $name = '';

    public $hostname = '';

    public $ip = '';

    public $os = 'linux';

    public $type = 'server';

    public $cpu_threshold = 80;

    public $ram_threshold = 80;

    public $disk_threshold = 80;

    public $network_threshold = 100;

    public $location = '';

    public $api_token = '';

    public $is_active = true;

    public $search = '';

    public $viewServer = null;
    public $loading = false;
    public $organisation_id = null;
    public $organisations = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'hostname' => 'required|string|max:255',
        'ip' => 'required|ip',
        'os' => 'required|in:linux,windows,macos',
        'type' => 'required|in:server,db,both',
        'cpu_threshold' => 'required|integer|min:1|max:100',
        'ram_threshold' => 'required|integer|min:1|max:100',
        'disk_threshold' => 'required|integer|min:1|max:100',
        'network_threshold' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->organisations = Organisation::where('is_active', true)->get();
    }

    public function render()
    {
        $user = Auth::user();
        $organisationId = $user ? $user->organisation_id : null;

        $servers = Server::when($organisationId, function ($query) use ($organisationId) {
                return $query->where('organisation_id', $organisationId);
            })
            ->where(function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('hostname', 'like', '%'.$this->search.'%')
                    ->orWhere('ip', 'like', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.server-list', compact('servers'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $server = Server::find($id);
            if (!$server) {
                session()->flash('error', 'Server not found!');
                return;
            }
            $this->serverId = $server->id;
            $this->organisation_id = $server->organisation_id;
            $this->name = $server->name;
            $this->hostname = $server->hostname;
            $this->ip = $server->ip;
            $this->os = $server->os;
            $this->type = $server->type;
            $this->cpu_threshold = $server->cpu_threshold;
            $this->ram_threshold = $server->ram_threshold;
            $this->disk_threshold = $server->disk_threshold;
            $this->network_threshold = $server->network_threshold;
            $this->location = $server->location ?? '';
            $this->api_token = $server->api_token ?? '';
            $this->is_active = $server->is_active;
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

    public function viewServer($id)
    {
        $server = Server::findOrFail($id);
        $this->viewServer = $server;
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->resetModals();
    }

    public function openView($id)
    {
        $this->viewServer($id);
    }

    public function afterAction()
    {
        $this->resetModals();
    }

    public function resetFields()
    {
        $this->serverId = null;
        $this->organisation_id = null;
        $this->name = '';
        $this->hostname = '';
        $this->ip = '';
        $this->os = 'linux';
        $this->type = 'server';
        $this->cpu_threshold = 80;
        $this->ram_threshold = 80;
        $this->disk_threshold = 80;
        $this->network_threshold = 100;
        $this->location = '';
        $this->api_token = '';
        $this->is_active = true;
    }

    public function save()
    {
        $this->loading = true;
        try {
            $this->validate();

            if ($this->serverId) {
                Server::find($this->serverId)->update([
                    'name' => $this->name,
                    'hostname' => $this->hostname,
                    'ip' => $this->ip,
                    'os' => $this->os,
                    'type' => $this->type,
                    'cpu_threshold' => $this->cpu_threshold,
                    'ram_threshold' => $this->ram_threshold,
                    'disk_threshold' => $this->disk_threshold,
                    'network_threshold' => $this->network_threshold,
                    'location' => $this->location,
                    'api_token' => $this->api_token,
                    'is_active' => $this->is_active,
                    'organisation_id' => $this->organisation_id,
                ]);
            } else {
                Server::create([
                    'name' => $this->name,
                    'hostname' => $this->hostname,
                    'ip' => $this->ip,
                    'os' => $this->os,
                    'type' => $this->type,
                    'cpu_threshold' => $this->cpu_threshold,
                    'ram_threshold' => $this->ram_threshold,
                    'disk_threshold' => $this->disk_threshold,
                    'network_threshold' => $this->network_threshold,
                    'location' => $this->location,
                    'api_token' => $this->api_token,
                    'is_active' => $this->is_active,
                    'organisation_id' => $this->organisation_id,
                ]);
            }

            $this->closeModal();
            session()->flash('message', 'Server saved successfully!');
        } finally {
            $this->loading = false;
        }
    }

    public function delete($id)
    {
        Server::find($id)->delete();
        $this->dispatch('recordDeleted');
    }

    public function confirmDelete($id)
    {
        $this->serverId = $id;
        $this->showDeleteModal = true;
        $this->showModal = false;
        $this->showViewModal = false;
    }

    public function cancelDelete()
    {
        $this->serverId = null;
        $this->showDeleteModal = false;
    }

public function executeDelete()
    {
        if ($this->serverId) {
            $server = Server::find($this->serverId);
            if ($server) {
                $server->delete();
            }
        }
        // Store delete success in session before redirecting
        session()->flash('message', 'Server deleted successfully!');
        
        // Redirect to trigger full page refresh
        return redirect()->route('servers');
    }

    public function pingServer($id)
    {
        $server = Server::find($id);
        if (!$server) {
            return;
        }

        session()->flash('message', 'Ping to ' . $server->ip . ' sent!');
        
        $this->resetModals();
    }
    
    public function resetModals()
    {
        $this->showModal = false;
        $this->showViewModal = false;
        $this->showDeleteModal = false;
        $this->viewServer = null;
        $this->serverId = null;
    }
}
