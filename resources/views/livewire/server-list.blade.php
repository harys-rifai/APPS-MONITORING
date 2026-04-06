@section('title', 'Servers')
<div class="glass-card">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6 p-6 pb-0">
            <div>
                <p class="text-gray-500">Configure and manage monitored servers</p>
            </div>
            <div>
                <button wire:click="openModal()" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg flex items-center gap-2 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Server
                </button>
            </div>
        </div>

        <div class="p-6 pt-0">
            <div class="mb-4">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" wire:model.live="search" placeholder="Search servers..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
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
                            <th class="pb-3 font-medium">IP</th>
                            <th class="pb-3 font-medium">OS</th>
                            <th class="pb-3 font-medium">CPU</th>
                            <th class="pb-3 font-medium">RAM</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($servers as $server)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $server->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $server->hostname }}</p>
                                    </div>
                                </td>
                                <td class="py-3 text-gray-600">{{ $server->ip }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-600 uppercase">{{ $server->os }}</span>
                                </td>
                                <td class="py-3 text-gray-600">{{ $server->cpu_threshold }}%</td>
                                <td class="py-3 text-gray-600">{{ $server->ram_threshold }}%</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded text-xs font-medium {{ $server->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $server->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="flex gap-2">
                                        @php
                                            $viewData = [
                                                'name' => $server->name,
                                                'hostname' => $server->hostname,
                                                'ip' => $server->ip,
                                                'os' => $server->os,
                                                'type' => $server->type,
                                                'location' => $server->location ?? 'N/A',
                                                'cpu_threshold' => $server->cpu_threshold ?? 'N/A',
                                                'ram_threshold' => $server->ram_threshold ?? 'N/A',
                                                'disk_threshold' => $server->disk_threshold ?? 'N/A',
                                                'network_threshold' => $server->network_threshold ?? 'N/A',
                                                'status' => $server->is_active ? 'Active' : 'Inactive'
                                            ];
                                        @endphp
                                        <button onclick="showViewModal('Server Details', JSON.parse('{{ addslashes(json_encode($viewData)) }}'))" class="text-indigo-600 hover:text-indigo-800" title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="openModal({{ $server->id }})" class="text-blue-600 hover:text-blue-800" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $server->id }})" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure?')">
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
                    {{ $servers->links() }}
                </div>
            </div>
        </div>

        @if($showModal)
            <div class="fixed inset-0 flex items-start justify-center z-50 pt-20">
                <div class="bg-white rounded-xl p-6 w-full max-w-lg border border-gray-200 shadow-lg max-h-[80vh] overflow-y-auto">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $serverId ? 'Edit Server' : 'Add Server' }}</h2>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Corporate</label>
                                <select wire:model="corporate_id" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                                    <option value="">Select Corporate</option>
                                    @foreach(\App\Models\Corporate::whereRaw('is_active = true')->get() as $corporate)
                                        <option value="{{ $corporate->id }}">{{ $corporate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Name</label>
                                <input type="text" wire:model="name" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Hostname</label>
                                <input type="text" wire:model="hostname" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">IP Address</label>
                                <input type="text" wire:model="ip" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">OS</label>
                                    <select wire:model="os" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                                        <option value="linux">Linux</option>
                                        <option value="windows">Windows</option>
                                        <option value="macos">macOS</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Type</label>
                                    <select wire:model="type" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                                        <option value="server">Server</option>
                                        <option value="db">Database</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">CPU Threshold (%)</label>
                                    <input type="number" wire:model="cpu_threshold" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">RAM Threshold (%)</label>
                                    <input type="number" wire:model="ram_threshold" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Disk Threshold (%)</label>
                                    <input type="number" wire:model="disk_threshold" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Network (Mbps)</label>
                                    <input type="number" wire:model="network_threshold" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Location</label>
                                <input type="text" wire:model="location" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">API Token</label>
                                <input type="text" wire:model="api_token" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-indigo-500">
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

        @if($showViewModal && $viewServer)
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl p-6 w-full max-w-2xl border border-gray-200 shadow-lg max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Server Details</h2>
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
                                <p class="font-medium text-gray-800">{{ $viewServer->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Hostname</p>
                                <p class="font-medium text-gray-800">{{ $viewServer->hostname }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">IP Address</p>
                                <p class="font-medium text-gray-800">{{ $viewServer->ip }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">OS</p>
                                <p class="font-medium text-gray-800 uppercase">{{ $viewServer->os }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Type</p>
                                <p class="font-medium text-gray-800">{{ $viewServer->type }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Location</p>
                                <p class="font-medium text-gray-800">{{ $viewServer->location ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">CPU Threshold</p>
                                <p class="font-medium text-gray-800">{{ $viewServer->cpu_threshold }}%</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">RAM Threshold</p>
                                <p class="font-medium text-gray-800">{{ $viewServer->ram_threshold }}%</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Disk Threshold</p>
                                <p class="font-medium text-gray-800">{{ $viewServer->disk_threshold }}%</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $viewServer->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $viewServer->is_active ? 'Active' : 'Inactive' }}
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