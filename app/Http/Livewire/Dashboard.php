<?php

namespace App\Http\Livewire;

use App\Models\Alert;
use App\Models\Database;
use App\Models\Server;
use App\Models\ServerMetric;
use App\Models\DbMetric;
use Illuminate\Support\Facades\Auth;
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
    public $serverChartData = [];
    public $dbChartData = [];

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
        $user = Auth::user();
        $organisationId = $user ? $user->organisation_id : null;

        $this->servers = Server::with('latestMetrics')
            ->whereRaw('is_active = true')
            ->when($organisationId, function($query) use ($organisationId) {
                return $query->where('organisation_id', $organisationId);
            })
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
            ->when($organisationId, function($query) use ($organisationId) {
                return $query->where('organisation_id', $organisationId);
            })
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
            ->when($organisationId, function($query) use ($organisationId) {
                return $query->whereHasMorph('alertable', [Server::class, Database::class], function($q) use ($organisationId) {
                    $q->where('organisation_id', $organisationId);
                });
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->toArray();

        $this->stats = [
            'total_servers' => Server::whereRaw('is_active = true')
                ->when($organisationId, function($query) use ($organisationId) {
                    return $query->where('organisation_id', $organisationId);
                })->count(),
            'total_databases' => Database::whereRaw('is_active = true')
                ->when($organisationId, function($query) use ($organisationId) {
                    return $query->where('organisation_id', $organisationId);
                })->count(),
            'spike_servers' => Server::where('status', 'spike')
                ->when($organisationId, function($query) use ($organisationId) {
                    return $query->where('organisation_id', $organisationId);
                })->count(),
            'spike_databases' => Database::where('status', 'spike')
                ->when($organisationId, function($query) use ($organisationId) {
                    return $query->where('organisation_id', $organisationId);
                })->count(),
            'total_alerts' => Alert::count(),
            'recent_spikes' => Alert::where('status', 'spike')->where('created_at', '>=', now()->subHours(24))->count(),
        ];

        $this->loadChartData();
    }

    private function loadChartData()
    {
        $this->serverChartData = $this->getServerMetricsChart();
        $this->dbChartData = $this->getDbMetricsChart();
    }

    private function getServerMetricsChart(): array
    {
        $metrics = ServerMetric::select(
                DB::raw('DATE_TRUNC(\'hour\', created_at) as hour'),
                DB::raw('AVG(cpu_usage) as cpu'),
                DB::raw('AVG(ram_usage) as ram'),
                DB::raw('AVG(disk_usage) as disk')
            )
            ->where('created_at', '>=', now()->subHours(24))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return $metrics->map(fn($m) => [
            'hour' => $m->hour->format('H:i'),
            'cpu' => round($m->cpu, 1),
            'ram' => round($m->ram, 1),
            'disk' => round($m->disk, 1),
        ])->toArray();
    }

    private function getDbMetricsChart(): array
    {
        $metrics = DbMetric::select(
                DB::raw('DATE_TRUNC(\'hour\', created_at) as hour'),
                DB::raw('SUM(active_count) as active'),
                DB::raw('SUM(idle_count) as idle'),
                DB::raw('SUM(locked_count) as locked')
            )
            ->where('created_at', '>=', now()->subHours(24))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return $metrics->map(fn($m) => [
            'hour' => $m->hour->format('H:i'),
            'active' => (int) $m->active,
            'idle' => (int) $m->idle,
            'locked' => (int) $m->locked,
        ])->toArray();
    }

    public function getServerTrend(int $serverId): array
    {
        return ServerMetric::where('server_id', $serverId)
            ->where('created_at', '>=', now()->subHours(24))
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'time' => $m->created_at->format('H:i'),
                'cpu' => $m->cpu_usage,
                'ram' => $m->ram_usage,
                'disk' => $m->disk_usage,
            ])->toArray();
    }

    public function getDatabaseTrend(int $databaseId): array
    {
        return DbMetric::where('database_id', $databaseId)
            ->where('created_at', '>=', now()->subHours(24))
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'time' => $m->created_at->format('H:i'),
                'active' => $m->active_count,
                'idle' => $m->idle_count,
                'locked' => $m->locked_count,
            ])->toArray();
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
