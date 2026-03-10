<?php /** @var \Illuminate\Pagination\LengthAwarePaginator $models */?>
@if (isset($entityType) && $models->isEmpty() && !$filterService->hasFilters())
    <x-lists.empty-state :entityType="$entityType" :campaign="$campaign" />
@else
<div class="flex gap-1 items-start">
    <x-box :padding="false" >
        <div class="table-responsive">
            @include($name . '.datagrid')
        </div>
    </x-box>
</div>
@include('ads.inline')

@includeWhen($models->hasPages() && !$models->onFirstPage() && auth()->check(), 'cruds.helpers.pagination', ['action' => 'index'])
@includeWhen(isset($datagridActions) && auth()->check() && $filteredCount > 0, 'cruds.datagrids.bulks.actions')

@if ($unfilteredCount != $filteredCount)
    <x-helper>
        <p>
            {{ __('crud.filters.filtered', ['count' => $filteredCount, 'total' => $unfilteredCount, 'entity' => __('entities.' . $name)]) }}
        </p>
    </x-helper>
@endif

@if($models->hasPages())
        {{ $models
            ->appends(isset($filterService) ? $filterService->pagination() : null)
            ->onEachSide(0)
            ->links(null, [
                'settingsLink' => base64_encode(route($route . '.index', $campaign))
]) }}
@endif
@endif
