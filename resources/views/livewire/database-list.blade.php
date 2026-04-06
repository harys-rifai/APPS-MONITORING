@section('title', 'Databases')
<div class="glass-card">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6 p-6 pb-0">
            <div>
                <p class="text-gray-500">Configure and manage monitored databases</p>
            </div>
            <div>
                <button wire:click="openModal()" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg flex items-center gap-2 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Database
                </button>
            </div>
        </div>

        <div class="p-6 pt-0">
            <div class="mb-4">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" wire:model.live="search" placeholder="Search databases..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="p-5">
                @if(session()->has('message'))
                    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 border-b border-gray-200">
                            <th class="pb-3 font-medium">Name</th>
                            <th class="pb-3 font-medium">Type</th>
                            <th class="pb-3 font-medium">Host</th>
                            <th class="pb-3 font-medium">Active</th>
                            <th class="pb-3 font-medium">Idle</th>
                            <th class="pb-3 font-medium">Locked</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($databases as $db)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $db->name }}</p>
                                        @if($db->server)
                                            <p class="text-sm text-gray-500">{{ $db->server->name }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded text-xs bg-purple-100 text-purple-700 uppercase">{{ $db->type }}</span>
                                </td>
                                <td class="py-3 text-gray-600">{{ $db->host }}:{{ $db->port }}</td>
                                <td class="py-3 text-gray-600">{{ $db->active_threshold }}</td>
                                <td class="py-3 text-gray-600">{{ $db->idle_threshold }}</td>
                                <td class="py-3 text-gray-600">{{ $db->lock_threshold }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded text-xs font-medium {{ $db->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $db->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('database.monitor', $db->id) }}" class="text-indigo-600 hover:text-indigo-800" title="Monitor">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </a>
                                        @php
                                            $viewData = [
                                                'name' => $db->name,
                                                'type' => $db->type,
                                                'host' => $db->host . ':' . $db->port,
                                                'database' => $db->database ?? 'N/A',
                                                'server' => $db->server->name ?? 'N/A',
                                                'active_threshold' => $db->active_threshold ?? 'N/A',
                                                'idle_threshold' => $db->idle_threshold ?? 'N/A',
                                                'lock_threshold' => $db->lock_threshold ?? 'N/A',
                                                'status' => $db->is_active ? 'Active' : 'Inactive'
                                            ];
                                        @endphp
                                        <button onclick="showViewModal('Database Details', JSON.parse('{{ addslashes(json_encode($viewData)) }}'))" class="text-gray-600 hover:text-gray-800" title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="openModal({{ $db->id }})" class="text-blue-600 hover:text-blue-800" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $db->id }})" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $databases->links() }}
                </div>
            </div>
        </div>

        @if($showModal)
            <div class="fixed inset-0 flex items-start justify-center z-50 pt-20">
                <div class="bg-white rounded-xl p-6 w-full max-w-lg border border-gray-200 shadow-lg max-h-[80vh] overflow-y-auto">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $databaseId ? 'Edit Database' : 'Add Database' }}</h2>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Corporate</label>
                                <select wire:model="corporate_id" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                                    <option value="">Select Corporate</option>
                                    @foreach(\App\Models\Corporate::whereRaw('is_active = true')->get() as $corporate)
                                        <option value="{{ $corporate->id }}">{{ $corporate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Name</label>
                                <input type="text" wire:model="name" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Type</label>
                                    <select wire:model="type" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                                        <option value="postgres">PostgreSQL</option>
                                        <option value="mysql">MySQL</option>
                                        <option value="sqlserver">SQL Server</option>
                                        <option value="db2">DB2</option>
                                        <option value="oracle">Oracle</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Server</label>
                                    <select wire:model="server_id" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                                        <option value="">None</option>
                                        @foreach(\App\Models\Server::whereRaw('is_active = true')->get() as $server)
                                            <option value="{{ $server->id }}">{{ $server->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Host</label>
                                    <input type="text" wire:model="host" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Port</label>
                                    <input type="number" wire:model="port" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Username</label>
                                    <input type="text" wire:model="username" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Password</label>
                                    <input type="password" wire:model="password" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Database Name</label>
                                <input type="text" wire:model="database" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Active Threshold</label>
                                    <input type="number" wire:model="active_threshold" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Idle Threshold</label>
                                    <input type="number" wire:model="idle_threshold" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Locked Threshold</label>
                                <input type="number" wire:model="lock_threshold" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" wire:model="is_active" class="rounded bg-gray-50 border-gray-200">
                                    <span class="text-sm text-gray-600">Active</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if($showViewModal && $viewDatabase)
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl p-6 w-full max-w-2xl border border-gray-200 shadow-lg max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Database Details</h2>
                        <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium text-gray-800">{{ $viewDatabase->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Type</p>
                                <p class="font-medium text-gray-800 uppercase">{{ $viewDatabase->type }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Host</p>
                                <p class="font-medium text-gray-800">{{ $viewDatabase->host }}:{{ $viewDatabase->port }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Database</p>
                                <p class="font-medium text-gray-800">{{ $viewDatabase->database }}</p>
                            </div>
                            @if($viewDatabase->server)
                            <div>
                                <p class="text-sm text-gray-500">Server</p>
                                <p class="font-medium text-gray-800">{{ $viewDatabase->server->name }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-500">Active Threshold</p>
                                <p class="font-medium text-gray-800">{{ $viewDatabase->active_threshold }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Idle Threshold</p>
                                <p class="font-medium text-gray-800">{{ $viewDatabase->idle_threshold }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Locked Threshold</p>
                                <p class="font-medium text-gray-800">{{ $viewDatabase->lock_threshold }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $viewDatabase->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $viewDatabase->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button wire:click="closeViewModal" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700">Close</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>