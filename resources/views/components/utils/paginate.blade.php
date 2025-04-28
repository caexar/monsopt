@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $firstPageToShow = max(1, $currentPage - 2);
            $lastPageToShow = min($lastPage, $currentPage + 2);
        @endphp

        @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : $this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1)

        <div class="hidden mt-6 sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm leading-5 dark:text-gray-300">
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        a
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    de
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    resultados
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-md rtl:flex-row-reverse">
                    {{-- Previous Page Link [<] --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-gray-300 bg-white border border-gray-300 cursor-default rounded-l-md dark:bg-body-dark dark:border-white/20" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <button
                            wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                            rel="prev"
                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-l-md focus:z-10 focus:outline-none dark:bg-body-dark dark:border-white/20 hover:bg-blue-50 hover:text-blue-500"
                            aria-label="{{ __('pagination.previous') }}"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif

                    {{-- First Page Link [1][...][28] --}}
                    @if ($firstPageToShow > 1)
                        <button
                            wire:click="gotoPage(1, '{{ $paginator->getPageName() }}')"
                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 focus:z-10 focus:outline-none dark:bg-body-dark dark:border-white/20 hover:bg-blue-50 hover:text-blue-500" aria-label="{{ __('Go to page :page', ['page' => 1]) }}"
                        >
                            1
                        </button>

                        @if ($firstPageToShow > 2)
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center justify-center px-4 py-2 mb-1 -ml-px text-sm font-medium leading-5 cursor-default">...</span>
                            </span>
                        @endif
                    @endif

                    {{-- Pagination Elements  [1][2][3] --}}
                    @foreach (range($firstPageToShow, $lastPageToShow) as $page)
                        <span wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page{{ $page }}">
                            @if ($page == $currentPage)
                                <span aria-current="page">
                                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-white bg-blue-500 border border-gray-300 cursor-default dark:border-white/20">{{ $page }}</span>
                                </span>
                            @else
                                <button
                                    wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 focus:z-10 focus:outline-none dark:bg-body-dark dark:border-white/20 hover:bg-blue-50 hover:text-blue-500"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                >
                                    {{ $page }}
                                </button>
                            @endif
                        </span>
                    @endforeach

                    {{-- Last Page Link [12][...][40] --}}
                    @if ($lastPageToShow < $lastPage)
                        @if ($lastPageToShow < $lastPage - 1)
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center justify-center px-4 py-2 mb-1 -ml-px text-sm font-medium leading-5 cursor-default">...</span>
                            </span>
                        @endif

                        <button
                            wire:click="gotoPage({{ $lastPage }}, '{{ $paginator->getPageName() }}')"
                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 focus:z-10 focus:outline-none dark:bg-body-dark dark:border-white/20 hover:bg-blue-50 hover:text-blue-500"
                            aria-label="{{ __('Go to page :page', ['page' => $lastPage]) }}"
                        >
                            {{ $lastPage }}
                        </button>
                    @endif

                    {{-- Next Page Link [>] --}}
                    @if ($paginator->hasMorePages())
                        <button
                            wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                            rel="next"
                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-r-md focus:z-10 focus:outline-none dark:bg-body-dark dark:border-white/20 hover:bg-blue-50 hover:text-blue-500"
                            aria-label="{{ __('pagination.next') }}"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 text-gray-300 bg-white border border-gray-300 cursor-default rounded-r-md dark:bg-body-dark dark:border-white/20" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
