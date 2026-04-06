<div class="min-h-screen bg-gray-900 text-white p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white">Server Management</h1>
                <p class="text-gray-400 mt-1">Configure and manage monitored servers</p>
            </div>
            <button wire:click="openModal()" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Server
            </button>
        </div>

        <div class="bg-gray-800 rounded-xl border border-gray-700">
            <div class="p-5">
                @if(session()->has('message'))
                    <div class="bg-green-500/20 text-green-400 p-3 rounded-lg mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-400 border-b border-gray-700">
                            <th class="pb-3 font-medium">Name</th>
                            <th class="pb-3 font-medium">IP</th>
                            <th class="pb-3 font-medium">OS</th>
                            <th class="pb-3 font-medium">CPU</th>
                            <th class="pb-3 font-medium">RAM</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($servers as $server)
                            <tr class="hover:bg-gray-700/30">
                                <td class="py-3">
                                    <div>
                                        <p class="font-medium text-white">{{ $server->name }}</p>
                                        <p class="text-sm text-gray-400">{{ $server->hostname }}</p>
                                    </div>
                                </td>
                                <td class="py-3 text-gray-300">{{ $server->ip }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded text-xs bg-gray-700 text-gray-300 uppercase">{{ $server->os }}</span>
                                </td>
                                <td class="py-3 text-gray-300">{{ $server->cpu_threshold }}%</td>
                                <td class="py-3 text-gray-300">{{ $server->ram_threshold }}%</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded text-xs font-medium {{ $server->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                        {{ $server->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="flex gap-2">
                                        <button wire:click="openModal({{ $server->id }})" class="text-blue-400 hover:text-blue-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $server->id }})" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure?')">
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
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-gray-800 rounded-xl p-6 w-full max-w-2xl border border-gray-700">
                    <h2 class="text-xl font-semibold mb-4">{{ $serverId ? 'Edit Server' : 'Add Server' }}</h2>
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm text-gray-400 mb-1">Name</label>
                                <input type="text" wire:model="name" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Hostname</label>
                                <input type="text" wire:model="hostname" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">IP Address</label>
                                <input type="text" wire:model="ip" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">OS</label>
                                <select wire:model="os" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                                    <option value="linux">Linux</option>
                                    <option value="windows">Windows</option>
                                    <option value="macos">macOS</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Type</label>
                                <select wire:model="type" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                                    <option value="server">Server</option>
                                    <option value="db">Database</option>
                                    <option value="both">Both</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">CPU Threshold (%)</label>
                                <input type="number" wire:model="cpu_threshold" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">RAM Threshold (%)</label>
                                <input type="number" wire:model="ram_threshold" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Disk Threshold (%)</label>
                                <input type="number" wire:model="disk_threshold" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Network Threshold (Mbps)</label>
                                <input type="number" wire:model="network_threshold" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm text-gray-400 mb-1">Location</label>
                                <input type="text" wire:model="location" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm text-gray-400 mb-1">API Token</label>
                                <input type="text" wire:model="api_token" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="col-span-2">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" wire:model="is_active" class="rounded bg-gray-700 border-gray-600">
                                    <span class="text-sm text-gray-400">Active</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>