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

@if ($paginator->hasPages() || $paginator->total() > 0)
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-row sm:flex-col items-center justify-between sm:gap-4 w-full">
        
        {{-- Info text: Left-aligned on desktop, centered on mobile --}}
        <div class="text-left sm:text-center w-auto sm:w-full">
            <span class="text-sm text-gray-500 font-medium h-8 flex items-center justify-start sm:justify-center">
                Menampilkan {{ $paginator->total() }} data
            </span>
        </div>

        {{-- Page Numbers: Right-aligned on desktop, centered on mobile --}}
        <div class="flex flex-wrap items-center justify-end sm:justify-center gap-1.5 max-w-full py-1">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-gray-300 bg-gray-50 border border-gray-100 rounded-md cursor-not-allowed">‹</span>
            @else
                <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-gray-600 bg-white border border-gray-200 rounded-md hover:bg-gray-50 hover:text-[#e51411] transition">‹</button>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex items-center justify-center px-2 h-8 text-xs font-medium text-gray-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex items-center justify-center w-8 h-8 text-xs font-extrabold text-white bg-[#e51411] border border-[#e51411] rounded-md shadow-sm">{{ $page }}</span>
                        @else
                            <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium text-gray-500 bg-white border border-gray-200 rounded-md hover:bg-gray-50 hover:text-[#e51411] transition" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-gray-600 bg-white border border-gray-200 rounded-md hover:bg-gray-50 hover:text-[#e51411] transition">›</button>
            @endif
        </div>
    </nav>
@endif
