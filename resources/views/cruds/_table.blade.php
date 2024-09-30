<div class="flex gap-1 items-start">
    <x-box :padding="false" >
        <div class="table-responsive">
            @include($name . '.datagrid')
        </div>
    </x-box>
    @include('ads.siderail_right')
</div>

@includeWhen($models->hasPages() && auth()->check(), 'cruds.helpers.pagination', ['action' => 'index'])
@includeWhen(auth()->check() && $filteredCount > 0 && isset($entityTypeId), 'cruds.datagrids.bulks.actions')

@if ($unfilteredCount != $filteredCount)
    <x-helper>
        {{ __('crud.filters.filtered', ['count' => $filteredCount, 'total' => $unfilteredCount, 'entity' => __('entities.' . $name)]) }}
    </x-helper>
@endif

@if($models->hasPages())
    <div class="">
        {{ $models->appends(isset($filterService) ? $filterService->pagination() : null)->onEachSide(0)->links() }}
    </div>
@endif
