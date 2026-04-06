<?php

namespace App\Http\Livewire;

use App\Models\Alert;
use App\Models\Database;
use App\Models\Server;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $servers = [];
    public $databases = [];
    public $recentAlerts = [];
    public $stats = [];

    protected $listeners = ['refreshDashboard' => '$refresh'];

    protected $paginationTheme = 'tailwind';

    protected function getListeners()
    {
        return [
            'refreshDashboard' => '$refresh',
            'poll' => '$refresh',
        ];
    }

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->servers = Server::with('latestMetrics')
            ->whereRaw('is_active = true')
            ->get()
            ->map(function ($server) {
                $server->status = $server->latestMetrics && 
                    ($server->latestMetrics->cpu_usage > $server->cpu_threshold ||
                     $server->latestMetrics->ram_usage > $server->ram_threshold ||
                     $server->latestMetrics->disk_usage > $server->disk_threshold) 
                    ? 'spike' : 'ok';
                return $server;
            })
            ->toArray();

        $this->databases = Database::with('latestMetrics')
            ->whereRaw('is_active = true')
            ->get()
            ->map(function ($db) {
                $db->status = $db->latestMetrics &&
                    ($db->latestMetrics->active_count > $db->active_threshold ||
                     $db->latestMetrics->locked_count > $db->lock_threshold)
                    ? 'spike' : 'ok';
                return $db;
            })
            ->toArray();

        $this->recentAlerts = Alert::with('alertable')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->toArray();

        $this->stats = [
            'total_servers' => Server::whereRaw('is_active = true')->count(),
            'total_databases' => Database::whereRaw('is_active = true')->count(),
            'spike_servers' => Server::where('status', 'spike')->count(),
            'spike_databases' => Database::where('status', 'spike')->count(),
            'total_alerts' => Alert::count(),
            'recent_spikes' => Alert::where('status', 'spike')->where('created_at', '>=', now()->subHours(24))->count(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard');
    }

    public function refresh()
    {
        $this->loadData();
    }
}