<?php

namespace App\Http\Livewire;

use App\Models\Server;
use App\Models\organisation;
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
        $this->organisations = organisation::where('is_active', true)->get();
    }

    public function render()
    {
        $user = Auth::user();
        $organisationId = $user ? $user->organisation_id : null;
        
        $servers = Server::whereRaw('is_active = true')
            ->when($organisationId, function($query) use ($organisationId) {
                return $query->where('organisation_id', $organisationId);
            })
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('hostname', 'like', '%' . $this->search . '%')
                    ->orWhere('ip', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        return view('livewire.server-list', compact('servers'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $server = Server::whereRaw('is_active = true')->find($id);
            $this->serverId = $server->id;
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
            $this->organisation_id = $server->organisation_id;
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
        $server = Server::whereRaw('is_active = true')->find($id);
        if ($server) {
            $this->viewServer = $server;
            $this->showViewModal = true;
        }
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewServer = null;
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
    }

    public function delete($id)
    {
        Server::find($id)->delete();
        session()->flash('message', 'Server deleted successfully!');
    }

    public function confirmDelete($id)
    {
        $this->serverId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->serverId = null;
        $this->showDeleteModal = false;
    }

public function executeDelete()
    {
        if ($this->serverId) {
            Server::find($this->serverId)->delete();
            session()->flash('message', 'Server deleted successfully!');
        }
        $this->cancelDelete();
    }

    public function pingServer($id)
    {
        $server = Server::find($id);
        if (!$server) return;

        $host = $server->ip;
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $command = "ping -n 1 -w 1000 " . escapeshellarg($host);
            $output = shell_exec($command);
            $success = stripos($output, 'Reply from') !== false || stripos($output, 'TTL=') !== false;
        } else {
            $command = "ping -c 1 -W 1 " . escapeshellarg($host);
            $output = shell_exec($command . " 2>&1");
            $success = stripos($output, '1 packets transmitted, 1 received') !== false || stripos($output, '64 bytes from') !== false;
        }

        $server->update([
            'ping_status' => $success ? 'ok' : 'failed',
            'pinged_at' => now(),
        ]);

        session()->flash('message', $success ? 'Server is reachable!' : 'Server is not reachable!');
    }
}
