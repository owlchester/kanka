<a href="{{ $route }}" class="btn2 btn-sm" data-toggle="tooltip" data-title="{{ __('crud.filters.lists.paginated') }}">
    <x-icon class="filter" />
    <span class="hidden xl:inline">
        @if ($all)
            {{ __('crud.filters.lists.desktop.all', ['count' => $count]) }}
        @else
            {{ __('crud.filters.lists.desktop.filtered', ['count' => $count]) }}
        @endif
    </span>
    <span class="xl:hidden">
        {{ $count }}
    </span>
</a>
