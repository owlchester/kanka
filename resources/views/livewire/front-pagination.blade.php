@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-6">
        {{-- Mobile View --}}
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm text-gray-400 bg-gray-100 rounded">Previous</span>
            @else
                <button wire:click="previousPage('page')" wire:loading.attr="disabled"
                        class="px-4 py-2 text-sm text-gray-700 bg-white border rounded hover:bg-light">
                    Previous
                </button>
            @endif

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage('page')" wire:loading.attr="disabled"
                        class="px-4 py-2 text-sm text-gray-700 bg-white border rounded hover:bg-light">
                    Next
                </button>
            @else
                <span class="px-4 py-2 text-sm text-gray-400 bg-gray-100 rounded">Next</span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-600">
                    Showing
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            <div>
                <span class="inline-flex items-center space-x-1">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 border rounded-l">‹</span>
                    @else
                        <button wire:click="previousPage('page')" wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border rounded-l hover:bg-gray-100">
                            ‹
                        </button>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="px-3 py-2 text-sm text-gray-500 bg-white border">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="px-3 py-2 text-sm text-white bg-purple border border-blue-600">{{ $page }}</span>
                                @else
                                    <button wire:click="gotoPage({{ $page }}, 'page')" wire:loading.attr="disabled"
                                            class="px-3 py-2 text-sm text-gray-700 bg-white border hover:bg-gray-100">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage('page')" wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border rounded-r hover:bg-gray-100">
                            ›
                        </button>
                    @else
                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 border rounded-r">›</span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
