@section('title', 'Realtime Database Monitor')
<div class="glass-card" wire:poll.5s="loadData">
    <div class="max-w-7xl mx-auto p-6">
        @if($error)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Error:</strong> {{ $error }}
            </div>
        @endif

        @if($database)
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">{{ $database->name }}</h2>
                <p class="text-gray-500">{{ $database->host }}:{{ $database->port }} ({{ $database->type }})</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <p class="text-gray-500 text-sm">Total Connections</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <p class="text-gray-500 text-sm">Active</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['active'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <p class="text-gray-500 text-sm">Idle</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['idle'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <p class="text-gray-500 text-sm">Locked</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['locked'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Database Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Database Info</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Version</span>
                            <span class="text-gray-800 font-medium">{{ $info['version'] ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Size</span>
                            <span class="text-gray-800 font-medium">{{ $info['size'] ?? 0 }} bytes</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tables</span>
                            <span class="text-gray-800 font-medium">{{ $info['tables'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Max Connections</span>
                            <span class="text-gray-800 font-medium">{{ $info['max_connections'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Connection Status</h3>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full {{ $isConnected ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        <span class="text-gray-800">{{ $isConnected ? 'Connected' : 'Disconnected' }}</span>
                        <button wire:click="loadData" class="ml-auto text-indigo-600 hover:text-indigo-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Active Connections -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">
                <div class="p-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Active Connections ({{ count($connections) }})</h3>
                </div>
                <div class="p-5">
                    @if(count($connections) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-sm text-gray-500 border-b border-gray-200">
                                    <th class="pb-2 font-medium">PID</th>
                                    <th class="pb-2 font-medium">User</th>
                                    <th class="pb-2 font-medium">App</th>
                                    <th class="pb-2 font-medium">Client IP</th>
                                    <th class="pb-2 font-medium">State</th>
                                    <th class="pb-2 font-medium">Query</th>
                                    <th class="pb-2 font-medium">Duration</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($this->getPaginatedConnections() as $conn)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 text-sm text-gray-600">{{ $conn['pid'] }}</td>
                                    <td class="py-2 text-sm text-gray-600">{{ $conn['username'] }}</td>
                                    <td class="py-2 text-sm text-gray-600">{{ $conn['application_name'] }}</td>
                                    <td class="py-2 text-sm text-gray-600">{{ $conn['client_ip'] }}</td>
                                    <td class="py-2">
                                        <span class="px-2 py-1 rounded text-xs font-medium 
                                            {{ $conn['state'] === 'active' ? 'bg-green-100 text-green-700' : 
                                            ($conn['state'] === 'idle' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                            {{ $conn['state'] }}
                                        </span>
                                    </td>
                                    <td class="py-2 text-sm text-gray-600 max-w-xs truncate" title="{{ $conn['query'] }}">{{ $conn['query'] }}</td>
                                    <td class="py-2 text-sm text-gray-600">{{ $conn['duration'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($this->getTotalConnectionsPages() > 1)
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            Page {{ $connectionsPage }} of {{ $this->getTotalConnectionsPages() }}
                        </div>
                        <div class="flex gap-2">
                            @if($connectionsPage > 1)
                            <button wire:click="$set('connectionsPage', {{ $connectionsPage - 1 }})" class="px-3 py-1 text-sm rounded border border-gray-300 hover:bg-gray-50">Previous</button>
                            @endif
                            @if($connectionsPage < $this->getTotalConnectionsPages())
                            <button wire:click="$set('connectionsPage', {{ $connectionsPage + 1 }})" class="px-3 py-1 text-sm rounded border border-gray-300 hover:bg-gray-50">Next</button>
                            @endif
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="text-center py-8 text-gray-500">
                        No active connections
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tables -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">
                <div class="p-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Tables ({{ count($tables) }})</h3>
                </div>
                <div class="p-5">
                    @if(count($tables) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-sm text-gray-500 border-b border-gray-200">
                                    <th class="pb-2 font-medium">#</th>
                                    <th class="pb-2 font-medium">Table</th>
                                    <th class="pb-2 font-medium">Table Size</th>
                                    <th class="pb-2 font-medium">Index Size</th>
                                    <th class="pb-2 font-medium">Total Size</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($this->getPaginatedTables() as $table)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 text-sm text-gray-600">{{ $table['n'] }}</td>
                                    <td class="py-2 text-sm text-gray-800 font-medium">{{ $table['name'] }}</td>
                                    <td class="py-2 text-sm text-gray-600">{{ $table['table_size'] }}</td>
                                    <td class="py-2 text-sm text-gray-600">{{ $table['index_size'] }}</td>
                                    <td class="py-2 text-sm text-gray-800 font-medium">{{ $table['total_size'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($this->getTotalTablesPages() > 1)
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            Page {{ $tablesPage }} of {{ $this->getTotalTablesPages() }}
                        </div>
                        <div class="flex gap-2">
                            @if($tablesPage > 1)
                            <button wire:click="$set('tablesPage', {{ $tablesPage - 1 }})" class="px-3 py-1 text-sm rounded border border-gray-300 hover:bg-gray-50">Previous</button>
                            @endif
                            @if($tablesPage < $this->getTotalTablesPages())
                            <button wire:click="$set('tablesPage', {{ $tablesPage + 1 }})" class="px-3 py-1 text-sm rounded border border-gray-300 hover:bg-gray-50">Next</button>
                            @endif
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="text-center py-8 text-gray-500">
                        No tables found
                    </div>
                    @endif
                </div>
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                Database not found
            </div>
        @endif
    </div>
</div>
