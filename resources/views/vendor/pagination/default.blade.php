@if ($paginator->hasPages())
    <nav class="flex items-center justify-between sm:px-0">
        {{-- Mobile View (Next & Previous only) --}}
        <div class="flex flex-1 justify-between sm:hidden mt-4 gap-2">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 text-xs font-bold text-gray-400 cursor-not-allowed">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500 transition-colors">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500 transition-colors">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 text-xs font-bold text-gray-400 cursor-not-allowed">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between mt-4">
            <div>
                <p class="text-[10px] font-medium uppercase tracking-widest text-gray-400 leading-5">
                    Halaman <span class="font-bold">{{ $paginator->currentPage() }}</span> dari <span class="font-bold">{{ $paginator->lastPage() }}</span>
                </p>
            </div>

            <div>
                <nav class="isolate inline-flex -space-x-px rounded-xl shadow-sm" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center rounded-l-xl px-3 py-2 text-gray-300 ring-1 ring-inset ring-gray-200 cursor-not-allowed bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <iconify-icon icon="solar:alt-arrow-left-line-duotone" class="text-lg"></iconify-icon>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center rounded-l-xl px-3 py-2 text-gray-500 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 transition-colors">
                            <span class="sr-only">Previous</span>
                            <iconify-icon icon="solar:alt-arrow-left-line-duotone" class="text-lg"></iconify-icon>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="relative z-10 inline-flex items-center bg-red-600 px-4 py-2 text-xs font-black text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 shadow-inner">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-xs font-bold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center rounded-r-xl px-3 py-2 text-gray-500 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 transition-colors">
                            <span class="sr-only">Next</span>
                            <iconify-icon icon="solar:alt-arrow-right-line-duotone" class="text-lg"></iconify-icon>
                        </a>
                    @else
                        <span class="relative inline-flex items-center rounded-r-xl px-3 py-2 text-gray-300 ring-1 ring-inset ring-gray-200 cursor-not-allowed bg-gray-50">
                            <span class="sr-only">Next</span>
                            <iconify-icon icon="solar:alt-arrow-right-line-duotone" class="text-lg"></iconify-icon>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </nav>
@endif
