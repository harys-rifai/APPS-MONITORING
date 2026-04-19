@props(['links' => null])

@if (isset($links) && $links instanceof \Illuminate\Pagination\LengthAwarePaginator)
    @php
        $paginator = $links;
    @endphp

    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-6 px-4 py-3 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="text-sm text-gray-500">
                @if ($paginator->firstItem())
                    <span class="text-gray-700 font-medium">{{ $paginator->firstItem() }} - {{ $paginator->lastItem() }}</span>
                    <span class="mx-1">of</span>
                    <span class="text-gray-700 font-medium">{{ $paginator->total() }} results</span>
                @else
                    <span>No results</span>
                @endif
            </div>

            <div class="text-sm text-gray-500">
                <span>Page</span>
                <span class="mx-1 font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-lg">{{ $paginator->currentPage() }}</span>
                <span class="mx-1">of</span>
                <span class="text-gray-700 font-medium">{{ $paginator->lastPage() }}</span>
            </div>

            <div class="flex items-center gap-2">
                @if ($paginator->onFirstPage())
                    <button disabled class="px-4 py-2 text-sm font-semibold text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Prev
                    </button>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg hover:from-indigo-700 hover:to-purple-700 shadow-md transition-all">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Prev
                    </a>
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg hover:from-indigo-700 hover:to-purple-700 shadow-md transition-all">
                        Next
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @else
                    <button disabled class="px-4 py-2 text-sm font-semibold text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        Next
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </nav>
    @endif
@endif

