<div>
@section('title', 'Audit Logs')
<div class="glass-card">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Audit Logs</h2>
        </div>

        @if(session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="mb-6 flex flex-wrap gap-4">

                        <div class="relative max-w-md">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input wire:model.live="search" type="text" placeholder="Search entity..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                        
                        <select wire:model.live="entityType" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">All Entities</option>
                            <option value="server">Server</option>
                            <option value="database">Database</option>
                            <option value="user">User</option>
                            <option value="organisation">Organisation</option>
                        </select>

                        <input wire:model.live="dateFrom" type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <input wire:model.live="dateTo" type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

                        <button wire:click="resetFilters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Reset</button>

                    </div>

                    <div class="overflow-x-auto">
<table class="w-full table-auto min-w-[700px]">
                    <thead>
                        <tr class="text-left text-xs uppercase text-gray-500 border-b border-gray-200 font-semibold tracking-wider">
                            <th class="pb-2 px-3">User</th>
                            <th class="pb-2 px-3">Action</th>
                            <th class="pb-2 px-3">Entity</th>
                            <th class="pb-2 px-3">Details</th>
                            <th class="pb-2 px-3">IP</th>
                            <th class="pb-2 px-3">Time</th>
                            <th class="pb-2 px-3 text-right">Actions</th>
                        </tr>
                    </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($logs as $log)
                                    <tr>
                                        <td class="py-2 px-3 whitespace-nowrap">
                                            <div class="text-xs font-medium text-gray-900 truncate">{{ $log->user->name ?? 'System' }}</div>
                                            <div class="text-xs text-gray-500">{{ $log->user->email ?? '' }}</div>
                                        </td>
                                        <td class="py-2 px-3 whitespace-nowrap">
                                            <span class="px-1.5 text-xs font-semibold rounded-full inline-flex leading-4 
                                                {{ $log->action === 'create' ? 'bg-green-100 text-green-800' : 
                                                   ($log->action === 'update' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                                {{ strtoupper($log->action) }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-3 text-xs text-gray-500 truncate">
                                            {{ $log->entity_type }} #{{ $log->entity_id }}
                                        </td>
                                        <td class="py-2 px-3 text-xs text-gray-500 max-w-[200px] truncate" title="{{ $log->message }}">
                                            {{ $log->message }}
                                        </td>
                                        <td class="py-2 px-3 text-xs text-gray-500 truncate">
                                            {{ Str::limit($log->ip_address, 15) }}
                                        </td>
                                        <td class="py-2 px-3 text-xs text-gray-500 truncate">
                                            {{ $log->created_at->format('d/M H:i') }}
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <button wire:click="viewLog({{ $log->id }})" class="text-indigo-600 hover:text-indigo-800 p-0.5 rounded-sm hover:bg-indigo-100" title="View details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No logs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
<x-tailwind-pagination :links="$logs" />
                    </div>
                </div>

                {{-- View Modal --}}
@if($showViewModal && $selectedLog)
                    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                        <div class="fixed inset-0" wire:click="closeViewModal"></div>
                        <div class="bg-white rounded-xl p-6 w-full max-w-lg border border-gray-200 shadow-lg max-h-[80vh] overflow-y-auto relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <div class="p-1.5 bg-indigo-100 rounded-lg">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-base font-semibold text-gray-800">Audit Log Details</h2>
                                </div>
                                <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-600 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-4 text-sm">
                                <div>
                                    <p class="text-gray-500 mb-1">User</p>
                                    <p class="font-medium text-gray-800">{{ $selectedLog->user->name ?? 'System' }}</p>
                                    <p class="text-gray-500 text-xs">{{ $selectedLog->user->email ?? '' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 mb-1">Action</p>
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $selectedLog->action === 'create' ? 'bg-green-100 text-green-800' : ($selectedLog->action === 'update' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($selectedLog->action) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-500 mb-1">Entity</p>
                                    <p class="font-medium text-gray-800">{{ ucfirst($selectedLog->entity_type) }} #{{ $selectedLog->entity_id }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 mb-1">IP Address</p>
                                    <p class="font-medium text-gray-800">{{ $selectedLog->ip_address }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 mb-1">Timestamp</p>
                                    <p class="font-medium text-gray-800">{{ $selectedLog->created_at->format('d M Y H:i:s') }}</p>
                                    <p class="text-xs text-gray-500">{{ $selectedLog->created_at->diffForHumans() }}</p>
                                </div>
                                @if($selectedLog->message)
                                    <div>
                                        <p class="text-gray-500 mb-1">Details</p>
                                        <p class="font-mono text-sm bg-gray-50 p-3 rounded-lg whitespace-pre-wrap max-h-32 overflow-y-auto">{{ $selectedLog->message }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="flex justify-end mt-6">
                                <button wire:click="closeViewModal" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm text-gray-700">Close</button>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
