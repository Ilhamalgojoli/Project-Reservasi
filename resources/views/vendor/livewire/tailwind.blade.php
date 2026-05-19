@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col gap-2 w-full">

            {{-- Row 1: HALAMAN X DARI Y - centered --}}
            <div class="text-center">
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                    Halaman <span class="font-black text-gray-700">{{ $paginator->currentPage() }}</span> dari <span class="font-black text-gray-700">{{ $paginator->lastPage() }}</span>
                </p>
            </div>

            {{-- Row 2: Previous (left) | Next (right) --}}
            <div class="flex items-center justify-between gap-2">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-gray-400 bg-white border border-gray-200 cursor-not-allowed leading-5 rounded-md whitespace-nowrap">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before" class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 active:bg-gray-100 transition ease-in-out duration-150 whitespace-nowrap">
                        {!! __('pagination.previous') !!}
                    </button>
                @endif

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before" class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 active:bg-gray-100 transition ease-in-out duration-150 whitespace-nowrap">
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-gray-400 bg-white border border-gray-200 cursor-not-allowed leading-5 rounded-md whitespace-nowrap">
                        {!! __('pagination.next') !!}
                    </span>
                @endif

            </div>

            {{-- Row 3: Page Numbers, scrollable from page 1 --}}
            <div class="overflow-x-auto">
                <span class="relative z-0 inline-flex rtl:flex-row-reverse rounded-md shadow-sm">
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page">
                                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">{{ $page }}</span>
                                        </span>
                                    @else
                                        <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                            {{ $page }}
                                        </button>
                                    @endif
                                </span>
                            @endforeach
                        @endif
                    @endforeach
                </span>
            </div>

        </nav>
    @endif
</div>
