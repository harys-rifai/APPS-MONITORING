@section('title', 'Dashboard')
@php
    use Illuminate\Support\Str;
@endphp

<div class="glass-card">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6 p-6 pb-0">
            <div>
                <p class="text-gray-500">Real-time server and database monitoring</p>
            </div>
            <div class="flex gap-4">
                <button wire:click="refresh" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg flex items-center gap-2 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        <div class="p-6 pt-0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Servers</p>
                            <p class="text-2xl font-bold mt-1 text-gray-800">{{ $stats['total_servers'] ?? 0 }}</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Databases</p>
                            <p class="text-2xl font-bold mt-1 text-gray-800">{{ $stats['total_databases'] ?? 0 }}</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Server Spikes</p>
                            <p class="text-2xl font-bold mt-1 text-red-600">{{ $stats['spike_servers'] ?? 0 }}</p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">DB Spikes (24h)</p>
                            <p class="text-2xl font-bold mt-1 text-orange-600">{{ $stats['recent_spikes'] ?? 0 }}</p>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Server Status</h2>
                    <span class="text-sm text-gray-500">{{ count($servers) }} servers</span>
                </div>
                <div class="p-5">
                    @if(count($servers) > 0)
                        <div class="space-y-4">
                            @foreach($servers as $server)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="font-medium text-gray-800">{{ $server['name'] }}</h3>
                                            <p class="text-sm text-gray-500">{{ $server['ip'] }} - {{ $server['os'] }}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $server['status'] === 'spike' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $server['status'] === 'spike' ? 'SPIKE' : 'OK' }}
                                        </span>
                                    </div>
                                    @if(!empty($server['latestMetrics']))
                                    <div class="grid grid-cols-4 gap-4 mt-3">
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">CPU</p>
                                            <p class="text-sm font-medium {{ $server['latestMetrics']['cpu_usage'] > $server['cpu_threshold'] ? 'text-red-600' : 'text-gray-700' }}">
                                                {{ $server['latestMetrics']['cpu_usage'] }}%
                                            </p>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                                @php $cpuWidth = min($server['latestMetrics']['cpu_usage'], 100); @endphp
                                                <div class="h-1.5 rounded-full {{ $server['latestMetrics']['cpu_usage'] > $server['cpu_threshold'] ? 'bg-red-500' : 'bg-blue-500' }}" style="width: {{ $cpuWidth }}%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">RAM</p>
                                            <p class="text-sm font-medium {{ $server['latestMetrics']['ram_usage'] > $server['ram_threshold'] ? 'text-red-600' : 'text-gray-700' }}">
                                                {{ $server['latestMetrics']['ram_usage'] }}%
                                            </p>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                                @php $ramWidth = min($server['latestMetrics']['ram_usage'], 100); @endphp
                                                <div class="h-1.5 rounded-full {{ $server['latestMetrics']['ram_usage'] > $server['ram_threshold'] ? 'bg-red-500' : 'bg-purple-500' }}" style="width: {{ $ramWidth }}%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Disk</p>
                                            <p class="text-sm font-medium {{ $server['latestMetrics']['disk_usage'] > $server['disk_threshold'] ? 'text-red-600' : 'text-gray-700' }}">
                                                {{ $server['latestMetrics']['disk_usage'] }}%
                                            </p>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                                @php $diskWidth = min($server['latestMetrics']['disk_usage'], 100); @endphp
                                                <div class="h-1.5 rounded-full {{ $server['latestMetrics']['disk_usage'] > $server['disk_threshold'] ? 'bg-red-500' : 'bg-yellow-500' }}" style="width: {{ $diskWidth }}%"></div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Network</p>
                                            <p class="text-sm font-medium text-gray-700">
                                                {{ round($server['latestMetrics']['network_in'] + $server['latestMetrics']['network_out']) }} Mbps
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2"></path>
                            </svg>
                            <p>No servers configured</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Database Status</h2>
                    <span class="text-sm text-gray-500">{{ count($databases) }} databases</span>
                </div>
                <div class="p-5">
                    @if(count($databases) > 0)
                        <div class="space-y-4">
                            @foreach($databases as $db)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="font-medium text-gray-800">{{ $db['name'] }}</h3>
                                            <p class="text-sm text-gray-500">{{ $db['type'] }} - {{ $db['host'] }}:{{ $db['port'] }}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $db['status'] === 'spike' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $db['status'] === 'spike' ? 'SPIKE' : 'OK' }}
                                        </span>
                                    </div>
                                    @if(!empty($db['latestMetrics']))
                                    <div class="grid grid-cols-3 gap-4 mt-3">
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Active</p>
                                            <p class="text-sm font-medium {{ $db['latestMetrics']['active_count'] > $db['active_threshold'] ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $db['latestMetrics']['active_count'] }}
                                            </p>
                                            <p class="text-xs text-gray-400">Max: {{ $db['active_threshold'] }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Idle</p>
                                            <p class="text-sm font-medium text-gray-700">
                                                {{ $db['latestMetrics']['idle_count'] }}
                                            </p>
                                            <p class="text-xs text-gray-400">Max: {{ $db['idle_threshold'] }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Locked</p>
                                            <p class="text-sm font-medium {{ $db['latestMetrics']['locked_count'] > $db['lock_threshold'] ? 'text-red-600' : 'text-gray-700' }}">
                                                {{ $db['latestMetrics']['locked_count'] }}
                                            </p>
                                            <p class="text-xs text-gray-400">Max: {{ $db['lock_threshold'] }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                            <p>No databases configured</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Recent Alerts</h2>
                <span class="text-sm text-gray-500">{{ count($recentAlerts) }} alerts</span>
            </div>
            <div class="p-5">
                @if(count($recentAlerts) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-sm text-gray-500 border-b border-gray-200">
                                    <th class="pb-3 font-medium">Time</th>
                                    <th class="pb-3 font-medium">Type</th>
                                    <th class="pb-3 font-medium">Entity</th>
                                    <th class="pb-3 font-medium">Status</th>
                                    <th class="pb-3 font-medium">Message</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($recentAlerts as $alert)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($alert['created_at'])->diffForHumans() }}
                                        </td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 rounded text-xs font-medium {{ $alert['type'] === 'server' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                                {{ $alert['type'] }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-sm text-gray-800">
                                            {{ $alert['alertable']['name'] ?? 'N/A' }}
                                        </td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 rounded text-xs font-medium {{ $alert['status'] === 'spike' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                {{ $alert['status'] }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-sm text-gray-600 max-w-md truncate">
                                            {{ Str::limit($alert['message'], 80) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p>No alerts recorded</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>