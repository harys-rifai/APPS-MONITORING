<div class="min-h-screen bg-gray-900 text-white p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white">Database Management</h1>
                <p class="text-gray-400 mt-1">Configure and manage monitored databases</p>
            </div>
            <button wire:click="openModal()" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Database
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
                            <th class="pb-3 font-medium">Type</th>
                            <th class="pb-3 font-medium">Host</th>
                            <th class="pb-3 font-medium">Active</th>
                            <th class="pb-3 font-medium">Idle</th>
                            <th class="pb-3 font-medium">Locked</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($databases as $db)
                            <tr class="hover:bg-gray-700/30">
                                <td class="py-3">
                                    <div>
                                        <p class="font-medium text-white">{{ $db->name }}</p>
                                        @if($db->server)
                                            <p class="text-sm text-gray-400">{{ $db->server->name }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded text-xs bg-purple-500/20 text-purple-400 uppercase">{{ $db->type }}</span>
                                </td>
                                <td class="py-3 text-gray-300">{{ $db->host }}:{{ $db->port }}</td>
                                <td class="py-3 text-gray-300">{{ $db->active_threshold }}</td>
                                <td class="py-3 text-gray-300">{{ $db->idle_threshold }}</td>
                                <td class="py-3 text-gray-300">{{ $db->lock_threshold }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded text-xs font-medium {{ $db->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                        {{ $db->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="flex gap-2">
                                        <button wire:click="openModal({{ $db->id }})" class="text-blue-400 hover:text-blue-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $db->id }})" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure?')">
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
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-gray-800 rounded-xl p-6 w-full max-w-2xl border border-gray-700">
                    <h2 class="text-xl font-semibold mb-4">{{ $databaseId ? 'Edit Database' : 'Add Database' }}</h2>
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm text-gray-400 mb-1">Name</label>
                                <input type="text" wire:model="name" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Type</label>
                                <select wire:model="type" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                                    <option value="postgres">PostgreSQL</option>
                                    <option value="mysql">MySQL</option>
                                    <option value="sqlserver">SQL Server</option>
                                    <option value="db2">DB2</option>
                                    <option value="oracle">Oracle</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Server</label>
                                <select wire:model="server_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                                    <option value="">None</option>
                                    @foreach(\App\Models\Server::where('is_active', true)->get() as $server)
                                        <option value="{{ $server->id }}">{{ $server->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Host</label>
                                <input type="text" wire:model="host" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Port</label>
                                <input type="number" wire:model="port" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Username</label>
                                <input type="text" wire:model="username" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Password</label>
                                <input type="password" wire:model="password" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm text-gray-400 mb-1">Database Name</label>
                                <input type="text" wire:model="database" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Active Threshold</label>
                                <input type="number" wire:model="active_threshold" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Idle Threshold</label>
                                <input type="number" wire:model="idle_threshold" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Locked Threshold</label>
                                <input type="number" wire:model="lock_threshold" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
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