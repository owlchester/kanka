@extends('layouts.app', [
    'title' => $titleKey ?? __('entities.' . $langKey),
    'seoTitle' => $titleKey ?? __('entities.' . $langKey) . ' - ' . $campaign->name,
    'breadcrumbs' => false,
    'canonical' => true,
    'bodyClass' => 'kanka-' . $name,
])

@section('entity-header')
    <div class="flex gap-2 items-center mb-5">
        <h1 class="grow text-4xl category-title">{!! $titleKey ?? __('entities.' . $langKey) !!}</h1>
        <div class="flex flex-wrap gap-2 justify-end">
            @includeWhen(isset($route) && $route !== 'relations', 'layouts.datagrid._togglers', ['route' => 'index'])
            @includeWhen(isset($actions), 'cruds.lists._actions')
            @includeWhen(isset($model) && auth()->check() && auth()->user()->can('create', $model), 'cruds.lists._create')
        </div>
    </div>
@endsection

@section('content')
    @include('partials.errors')

    <div class="flex flex-col gap-5">
    @if (auth()->guest())
        <div class="text-muted grow">
            <i class="fa-solid fa-filter" aria-hidden="true"></i>
            {{ __('filters.helpers.guest') }}
        </div>
    @else
        @if (isset($route))
            <div class="flex flex-stretch gap-2 items-center">
                    @includeWhen(isset($model) && $model->hasSearchableFields(), 'layouts.datagrid.search', ['route' => [$route . '.index', $campaign]])
                    @includeWhen(isset($filter) && $filter !== false, 'cruds.datagrids.filters.datagrid-filter', ['route' => $route . '.index', $campaign])
            </div>
        @endif
    @endif

    @include('partials.ads.top')

    @if (!isset($mode) || $mode === 'grid')
        @include('cruds.datagrids.explore', ['route' => $route . '.index'])
    @else
        @if (isset($entityTypeId))
            <x-form class="flex flex-col gap-5" :action="['bulk.print', [$campaign, 'entity_type' => $entityTypeId]]" direct>
        @endif
        <x-box :padding="false" >
            <div class="table-responsive">
                @include($name . '.datagrid')
            </div>
        </x-box>

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
        @if (isset($entityTypeId))
            <input type="hidden" name="page" value="{{ request()->get('page') }}" />
        </x-form>
        @endif


        <input type="hidden" class="list-treeview" value="1" data-url="{{ route($route . '.index', $campaign) }}">

    @endif
    </div>
@endsection

@section('modals')
    @parent
    @includeWhen(auth()->check(), 'cruds.datagrids.bulks.modals')
@endsection


