@section('title', 'organisation Management')
<div class="glass-card">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">organisation Management</h2>
            <button wire:click="openModal()" class="btn-soft flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Organisation
                </button>
        </div>

        @if(session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="mb-4">
            <div class="relative max-w-md">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search organisation..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
        </div>

        @if ($organisations->hasPages())
        <div class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500 mb-4">
            <div>
                Showing {{ $organisations->firstItem() ?? 0 }} to {{ $organisations->lastItem() }} of {{ $organisations->total() }} results
            </div>
            <div>
                Page {{ $organisations->currentPage() }} of {{ $organisations->lastPage() }}
            </div>
        </div>
        @endif

        <div class="overflow-x-auto">
<table class="w-full table-auto min-w-[700px]">
                <thead>
                    <tr class="text-left text-xs uppercase text-gray-500 border-b border-gray-200 font-semibold tracking-wider">
                        <th class="pb-2 px-3">Name</th>

                        <th class="pb-2 px-3 text-center">Users</th>
                        <th class="pb-2 px-3 text-center">Servers</th>
                        <th class="pb-2 px-3 text-center">Databases</th>
                        <th class="pb-2 px-3 text-center">Status</th>
                        <th class="pb-2 px-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($organisations as $organisation)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-3 text-xs font-medium text-gray-800 truncate">{{ $organisation->name }}</td>

                        <td class="py-2 px-3 text-center text-xs text-gray-600">{{ $organisation->users->count() }}</td>
                        <td class="py-2 px-3 text-center text-xs text-gray-600">{{ $organisation->servers->count() }}</td>
                        <td class="py-2 px-3 text-center text-xs text-gray-600">{{ $organisation->databases->count() }}</td>
                        <td class="py-2 px-3 text-center">
                            <button wire:click="toggleActive({{ $organisation->id }})" class="px-1.5 py-0.5 rounded text-xs font-medium {{ $organisation->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $organisation->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="py-3 px-3 text-right">
                            <div class="flex gap-1 justify-end items-center">
                                <button wire:click="viewOrganisation({{ $organisation->id }})" class="text-indigo-600 hover:text-indigo-800 p-0.5 rounded-sm hover:bg-indigo-100" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button wire:click="openModal({{ $organisation->id }})" class="text-blue-600 hover:text-blue-800 p-0.5 rounded-sm hover:bg-blue-100" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $organisation->id }})" class="text-red-600 hover:text-red-800 p-0.5 rounded-sm hover:bg-red-100" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <x-tailwind-pagination :links="$organisations" />
        </div>
    </div>

@if($showModal)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="fixed inset-0" wire:click="closeModal"></div>
        <div class="bg-white rounded-xl p-6 w-full max-w-md border border-gray-200 shadow-lg relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold">{{ $organisationId ? 'Edit organisation' : 'Add organisation' }}</h3>
                </div>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form wire:submit.prevent="save" wire:loading.attr="disabled">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" wire:model="name" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @else border-gray-300 @endif">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 text-indigo-600">
                        <label for="is_active" class="text-sm text-gray-700">Active</label>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg" wire:loading.attr="disabled">Cancel</button>
                    <button type="submit" class="btn-soft w-full" wire:loading.attr="disabled">
                        <div wire:loading wire:target="save" class="animate-spin h-4 w-4 text-white mr-2" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 6.627 12 14s6.627 14 14 14v-4a8 8 0 01-8 8H4z"></path>
                        </div>
                        <span wire:loading.remove>Saving...</span>
                        <span wire:loading.delay.remove wire:target="save">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

@if($showViewModal && $viewOrganisation)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="fixed inset-0" wire:click="closeViewModal"></div>
        <div class="bg-white rounded-xl p-6 w-full max-w-md border border-gray-200 shadow-lg relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold">{{ $viewOrganisation->name }}</h3>
                </div>
                <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b">

                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-500">Status:</span>
                    <span class="px-2 py-1 rounded text-xs font-medium {{ $viewOrganisation->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $viewOrganisation->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="border-t pt-3">
                    <h4 class="font-medium text-gray-800 mb-2">Users ({{ $viewOrganisation->users->count() }})</h4>
                    @if($viewOrganisation->users->count() > 0)
                        <div class="flex flex-wrap gap-1">
                            @foreach($viewOrganisation->users as $user)
                                <span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $user->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No users assigned</p>
                    @endif
                </div>
                <div class="border-t pt-3">
                    <h4 class="font-medium text-gray-800 mb-2">Servers ({{ $viewOrganisation->servers->count() }})</h4>
                    @if($viewOrganisation->servers->count() > 0)
                        <div class="flex flex-wrap gap-1">
                            @foreach($viewOrganisation->servers as $server)
                                <span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $server->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No servers assigned</p>
                    @endif
                </div>
                <div class="border-t pt-3">
                    <h4 class="font-medium text-gray-800 mb-2">Databases ({{ $viewOrganisation->databases->count() }})</h4>
                    @if($viewOrganisation->databases->count() > 0)
                        <div class="flex flex-wrap gap-1">
                            @foreach($viewOrganisation->databases as $db)
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

@if($showDeleteModal)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="fixed inset-0 bg-black/30" wire:click="cancelDelete"></div>
        <div class="bg-white rounded-xl p-6 w-full max-w-sm border border-gray-200 shadow-lg relative z-10">
            <div class="text-center">
                <div class="p-3 bg-red-100 rounded-full mx-auto w-12 h-12 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Delete organisation</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this organisation? This action cannot be undone.</p>
                <div class="flex justify-center gap-3">
                    <button wire:click="cancelDelete" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</button>
                    <button wire:click="executeDelete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
