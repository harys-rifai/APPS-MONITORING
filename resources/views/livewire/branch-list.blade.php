@section('title', 'Branch Management')
<div class="glass-card">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Branch Management</h2>
            <button wire:click="openModal()" class="bg-indigo-600 hover:bg-indigo-700 px-3 py-1.5 rounded-lg flex items-center gap-1.5 text-sm font-medium text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Branch
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
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search branches..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto min-w-[700px]">
                <thead>
                    <tr class="text-left text-xs uppercase text-gray-500 border-b border-gray-200 font-semibold tracking-wider">
                        <th class="pb-2 px-3">Name</th>
                        <th class="pb-2 px-3">Organisation</th>
                        <th class="pb-2 px-3">Location</th>
                        <th class="pb-2 px-3 text-center">Users</th>
                        <th class="pb-2 px-3 text-center">Servers</th>
                        <th class="pb-2 px-3 text-center">Databases</th>
                        <th class="pb-2 px-3 text-center">Status</th>
                        <th class="pb-2 px-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($branches as $branch)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-3 text-xs font-medium text-gray-800 truncate">{{ $branch->name }}</td>
                        <td class="py-2 px-3 text-xs text-gray-600 truncate">{{ $branch->organisation->name }}</td>
                        <td class="py-2 px-3 text-xs text-gray-600 truncate">{{ $branch->location ?? '-' }}</td>
                        <td class="py-2 px-3 text-center text-xs text-gray-600">{{ $branch->users->count() }}</td>
                        <td class="py-2 px-3 text-center text-xs text-gray-600">{{ $branch->servers->count() }}</td>
                        <td class="py-2 px-3 text-center text-xs text-gray-600">{{ $branch->databases->count() }}</td>
                        <td class="py-2 px-3 text-center">
                            <button wire:click="toggleActive({{ $branch->id }})" class="px-1.5 py-0.5 rounded text-xs font-medium {{ $branch->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $branch->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="py-3 px-3 text-right">
                            <div class="flex gap-1 justify-end items-center">
                                <button wire:click="viewBranch({{ $branch->id }})" class="text-indigo-600 hover:text-indigo-800 p-0.5 rounded-sm hover:bg-indigo-100" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button wire:click="openModal({{ $branch->id }})" class="text-blue-600 hover:text-blue-800 p-0.5 rounded-sm hover:bg-blue-100" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $branch->id }})" class="text-red-600 hover:text-red-800 p-0.5 rounded-sm hover:bg-red-100" title="Delete">
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
<x-tailwind-pagination :links="$branches" />
        </div>
    </div>

@if($showModal)
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="fixed inset-0" wire:click="closeModal"></div>
        <div class="bg-white rounded-xl p-6 w-full max-w-md border border-gray-200 shadow-lg relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold">{{ $branchId ? 'Edit Branch' : 'Add Branch' }}</h3>
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Organisation</label>
                        <select wire:model="organisation_id" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 @error('organisation_id') border-red-500 @else border-gray-300 @endif">
                            <option value="">Select Organisation</option>
                            @foreach($organisations as $org)
                                <option value="{{ $org->id }}">{{ $org->name }}</option>
                            @endforeach
                        </select>
                        @error('organisation_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" wire:model="name" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @else border-gray-300 @endif">
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
                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg" wire:loading.attr="disabled">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center gap-2" wire:loading.attr="disabled">
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

@if($showViewModal && $viewBranch)
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0 scale-95" 
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="opacity-100 scale-100" 
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
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
                    <h3 class="text-lg font-semibold">{{ $viewBranch->name }}</h3>
                </div>
                <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs uppercase text-gray-500 font-semibold mb-1">Organisation</p>
                        <p class="text-gray-800 font-medium">{{ $viewBranch->organisation->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500 font-semibold mb-1">Location</p>
                        <p class="text-gray-800 font-medium">{{ $viewBranch->location ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500 font-semibold mb-1">Status</p>
                        <span class="px-2 py-1 rounded text-xs font-medium {{ $viewBranch->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $viewBranch->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h4 class="font-semibold text-gray-800 mb-4">Related Resources</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-xs text-gray-600 mb-1">Users</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $viewBranch->users->count() }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <p class="text-xs text-gray-600 mb-1">Servers</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $viewBranch->servers->count() }}</p>
                        </div>
                        <div class="bg-cyan-50 p-4 rounded-lg">
                            <p class="text-xs text-gray-600 mb-1">Databases</p>
                            <p class="text-2xl font-bold text-cyan-600">{{ $viewBranch->databases->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if($showDeleteModal)
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0 scale-95" 
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="opacity-100 scale-100" 
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="fixed inset-0" wire:click="cancelDelete"></div>
        <div class="bg-white rounded-xl p-6 w-full max-w-sm border border-gray-200 shadow-lg relative z-10">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-900 text-center">Delete Branch?</h3>
            <p class="mt-2 text-sm text-gray-500 text-center">This action cannot be undone.</p>
            <div class="flex justify-center gap-3 mt-6">
                <button wire:click="cancelDelete" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Cancel</button>
                <button wire:click="executeDelete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>
@endif
