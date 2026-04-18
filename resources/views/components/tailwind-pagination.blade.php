@props(['links' => null])

@if (isset($links) && $links instanceof \Illuminate\Pagination\LengthAwarePaginator)
    @php
        $paginator = $links;
        $elements = $paginator->linkFactory()->elements();
    @endphp

    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <div class="flex flex-1 justify-between sm:hidden">
                @if ($paginator->onFirstPage())
class="bg-white px-3 py-1 border-r border-t border-b text-gray-500 cursor-not-allowed text-sm font-medium rounded-md"
                @else
class="bg-white px-3 py-1 border-r border-t border-b text-black no-underline hover:bg-gray-50 text-sm font-medium rounded-md"
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="relative ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700" rel="next" aria-label="Next Page">Next</a>
                @else
                    <span class="relative ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 cursor-not-allowed">Next</span>
                @endif
            </div>

            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-4">
                        Showing
                        @if ($paginator->firstItem())
                            <span class="font-medium">{{ $paginator->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        @else
                            zero
                        @endif
                        of
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        results
                    </p>
                </div>

                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
class="bg-white px-3 py-1 border-r border-t border-b text-gray-500 cursor-not-allowed text-sm font-medium rounded-l-md"
                        @else
class="bg-white px-3 py-1 border-r border-t border-b text-black no-underline hover:bg-gray-50 text-sm font-medium rounded-l-md"
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- Array Of Links In Pagination Elements --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
class="bg-yellow-100 border-yellow-500 font-bold text-sm px-3 py-1 border border-gray-300 z-10"
                                    @else
class="bg-white px-3 py-1 border border-gray-300 text-black no-underline hover:bg-gray-50 text-sm font-medium"
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
class="bg-white px-3 py-1 border-r border-t border-b text-black no-underline hover:bg-gray-50 text-sm font-medium rounded-r-md"
                        @else
class="bg-white px-3 py-1 border-r border-t border-b text-gray-500 cursor-not-allowed text-sm font-medium rounded-r-md"
                        @endif
                    </nav>
                </div>
            </div>
        </nav>
    @endif
@endif

