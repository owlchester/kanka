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
        <div class="flex flex-wrap gap-2  justify-end">
            @include('layouts.datagrid._togglers', ['route' => 'tree'])
            @include('cruds.lists._actions')
            @includeWhen(auth()->check() && auth()->user()->can('create', [$entityType, $campaign]), 'cruds.lists._create')
        </div>
    </div>
@endsection

@section('content')

    @include('partials.errors')

    <div class="flex flex-col gap-5">
    @if (auth()->guest())
        <div class="flex flex-stretch gap-2 items-center">
            <div class="text-muted grow">
                <x-icon class="fa-regular fa-filter" />
                {{ __('filters.helpers.guest') }}
            </div>

            @if ($filterService->activeFiltersCount() > 0)
                @if (isset($entityType) && $entityType->isCustom())
                    <a href="{{ route('entities.index', [$campaign, $entityType, 'reset-filter' => 'true']) }}" class="btn2 btn-ghost btn-sm">
                        <x-icon class="fa-regular fa-eraser" /> {{ __('crud.filters.clear') }}
                    </a>
                @else
                    <a href="{{ route($route . '.index', [$campaign, 'reset-filter' => 'true']) }}" class="btn2 btn-ghost btn-sm">
                        <x-icon class="fa-regular fa-eraser" /> {{ __('crud.filters.clear') }}
                    </a>
                @endif
            @endif
        </div>
    @else
        <div class="flex flex-stretch gap-2 items-center">
            @includeWhen($model->hasSearchableFields(), 'layouts.datagrid.search', ['route' => route($route . '.index', $campaign)])
            @includeWhen(isset($filter) && $filter !== false, 'cruds.datagrids.filters.datagrid-filter', ['route' => $route . '.index'])
        </div>
    @endif

    @include('ads.top')

    @if (!isset($mode) || $mode === 'grid')
        @include('cruds.datagrids.explore', ['nested' => true, 'sub' => 'tree'])
    @else
        <x-form :action="['bulk.process', $campaign]" class="flex flex-col gap-5">
        <x-box :padding="false">
            <div class="table-responsive">
                @include($name . '._tree')
            </div>
        </x-box>

        @includeWhen($models->hasPages() && auth()->check(), 'cruds.helpers.pagination', ['action' => 'tree'])

        @includeWhen(auth()->check() && $filteredCount > 0, 'cruds.datagrids.bulks.actions')

        @if ($unfilteredCount != $filteredCount)
            <x-helper>
                <p>{{ __('crud.filters.filtered', ['count' => $filteredCount, 'total' => $unfilteredCount, 'entity' => __('entities.' . $name)]) }}</p>
            </x-helper>
        @endif
        @if($models->hasPages())
        <div class="">
            {{ $models->appends('parent_id', request()->get('parent_id'))->onEachSide(0)->links() }}
        </div>
        @endif
        <input type="hidden" name="entity" value="{{ $name }}" />
        <input type="hidden" name="datagrid-action" value="print" />
            <input type="hidden" name="page" value="{{ request()->get('page') }}" />
            <input type="hidden" name="mode" value="{{ $mode }}" />
        </x-form>

    @endif
    </div>

    <input type="hidden" class="list-treeview" value="1" data-url="{{ route($route . '.index', $campaign) }}">
@endsection

@section('modals')
    @parent
    @includeWhen(auth()->check(), 'cruds.datagrids.bulks.modals')
@endsection
