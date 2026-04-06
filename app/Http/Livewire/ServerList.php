<?php

namespace App\Http\Livewire;

use App\Models\Server;
use Livewire\Component;
use Livewire\WithPagination;

class ServerList extends Component
{
    use WithPagination;

    public $showModal = false;
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

    public function render()
    {
        $servers = Server::whereRaw('is_active = true')->paginate(10);
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

    public function resetFields()
    {
        $this->serverId = null;
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
}