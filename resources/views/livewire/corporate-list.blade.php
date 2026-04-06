@section('title', 'Corporate Management')
<div class="glass-card">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Corporate Management</h2>
            <button wire:click="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Corporate
            </button>
        </div>

        @if(session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="mb-4">
            <input type="text" wire:model.live="search" placeholder="Search corporate..." 
                class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-sm text-gray-500 border-b border-gray-200">
                        <th class="pb-3 font-medium">Name</th>
                        <th class="pb-3 font-medium">Location</th>
                        <th class="pb-3 font-medium">Users</th>
                        <th class="pb-3 font-medium">Servers</th>
                        <th class="pb-3 font-medium">Databases</th>
                        <th class="pb-3 font-medium">Status</th>
                        <th class="pb-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($corporates as $corporate)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 text-sm text-gray-800 font-medium">{{ $corporate->name }}</td>
                        <td class="py-3 text-sm text-gray-600">{{ $corporate->location ?? '-' }}</td>
                        <td class="py-3 text-sm text-gray-600">{{ $corporate->users->count() }}</td>
                        <td class="py-3 text-sm text-gray-600">{{ $corporate->servers->count() }}</td>
                        <td class="py-3 text-sm text-gray-600">{{ $corporate->databases->count() }}</td>
                        <td class="py-3">
                            <button wire:click="toggleActive({{ $corporate->id }})" class="px-2 py-1 rounded text-xs font-medium {{ $corporate->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $corporate->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                @php
                                    $viewData = [
                                        'name' => $corporate->name,
                                        'location' => $corporate->location ?? 'N/A',
                                        'users_count' => (string) $corporate->users->count(),
                                        'servers_count' => (string) $corporate->servers->count(),
                                        'databases_count' => (string) $corporate->databases->count(),
                                        'status' => $corporate->is_active ? 'Active' : 'Inactive'
                                    ];
                                @endphp
                                <button onclick="showViewModal('Corporate Details', JSON.parse('{{ addslashes(json_encode($viewData)) }}'))" class="text-indigo-600 hover:text-indigo-800 p-1" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button wire:click="openModal({{ $corporate->id }})" class="text-blue-600 hover:text-blue-800 p-1" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button wire:click="delete({{ $corporate->id }})" class="text-red-600 hover:text-red-800 p-1" title="Delete" onclick="return confirm('Are you sure?')">
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
        </div>

        <div class="mt-4">
            {{ $corporates->links() }}
        </div>
    </div>

    @if($showModal)
    <div class="fixed inset-0 flex items-start justify-center z-50 pt-20">
        <div class="bg-white rounded-xl p-6 w-full max-w-md border border-gray-200 shadow-lg">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold">{{ $corporateId ? 'Edit Corporate' : 'Add Corporate' }}</h3>
            </div>
            <form wire:submit.prevent="save">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" wire:model="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" wire:model="location" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 text-indigo-600">
                        <label for="is_active" class="text-sm text-gray-700">Active</label>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Save</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($showViewModal && $viewCorporate)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold mb-4">{{ $viewCorporate->name }}</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Location:</span>
                    <span class="text-gray-800">{{ $viewCorporate->location ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status:</span>
                    <span class="px-2 py-1 rounded text-xs font-medium {{ $viewCorporate->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $viewCorporate->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="border-t pt-3">
                    <h4 class="font-medium text-gray-800 mb-2">Users ({{ $viewCorporate->users->count() }})</h4>
                    @if($viewCorporate->users->count() > 0)
                        <div class="flex flex-wrap gap-1">
                            @foreach($viewCorporate->users as $user)
                                <span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $user->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No users assigned</p>
                    @endif
                </div>
                <div class="border-t pt-3">
                    <h4 class="font-medium text-gray-800 mb-2">Servers ({{ $viewCorporate->servers->count() }})</h4>
                    @if($viewCorporate->servers->count() > 0)
                        <div class="flex flex-wrap gap-1">
                            @foreach($viewCorporate->servers as $server)
                                <span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $server->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No servers assigned</p>
                    @endif
                </div>
                <div class="border-t pt-3">
                    <h4 class="font-medium text-gray-800 mb-2">Databases ({{ $viewCorporate->databases->count() }})</h4>
                    @if($viewCorporate->databases->count() > 0)
                        <div class="flex flex-wrap gap-1">
                            @foreach($viewCorporate->databases as $db)
                                <span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $db->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No databases assigned</p>
                    @endif
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button wire:click="closeViewModal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Close</button>
            </div>
        </div>
    </div>
    @endif
</div>