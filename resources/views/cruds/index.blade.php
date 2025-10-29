@extends('layouts.app', [
    'title' => $titleKey ?? __('entities.' . $langKey),
    'seoTitle' => $titleKey ?? __('entities.' . $langKey) . ' - ' . $campaign->name,

    'breadcrumbs' => false,
    'canonical' => true,
    'bodyClass' => 'kanka-' . $name,
])

@section('entity-header')
    <div class="flex gap-2 items-center mb-5">
        <h1 class="grow text-4xl category-title truncate">{!! $titleKey ?? __('entities.' . $langKey) !!}</h1>
        <div class="flex flex-wrap gap-2 justify-end">
            @includeWhen(isset($route) && $route !== 'relations', 'layouts.datagrid._togglers', ['route' => $name . '.index'])
            @includeWhen(isset($actions), 'cruds.lists._actions')
            @if (isset($entityType))
                @includeWhen(isset($model) && auth()->check() && auth()->user()->can('create', [$entityType, $campaign]), 'cruds.lists._create')
            @else
                @includeWhen(isset($model) && auth()->check() && auth()->user()->can('create', $model), 'cruds.lists._create')
            @endif
        </div>
    </div>
@endsection

@section('content')
    @include('partials.errors')

    @include('ads.top')

    <div class="flex flex-col gap-5">
    @if (auth()->guest())
        @include('cruds.clear-filters')
    @else
        @if (isset($route))
            <div class="flex flex-stretch gap-2 items-center">
                    @includeWhen(isset($model) && $model->hasSearchableFields(), 'layouts.datagrid.search', ['route' => [$route . '.index', $campaign]])
                    @includeWhen(isset($filter) && $filter !== false, 'cruds.datagrids.filters.datagrid-filter', ['route' => $route . '.index', $campaign])
            </div>
        @endif
    @endif

    @if (!isset($mode) || $mode === 'grid')
        @include('cruds.datagrids.explore', ['route' => $route . '.index'])
    @else
        @if (isset($entityType))
            <x-form class="flex flex-col gap-5" :action="['bulk.print', [$campaign, 'entity_type' => $entityType]]" direct>
                @include('cruds._table')
                <input type="hidden" name="page" value="{{ request()->get('page') }}" />
            </x-form>
            <input type="hidden" class="list-treeview" value="1" data-url="{{ route($route . '.index', $campaign) }}">
        @else
            @include('cruds._table')
        @endif


    @endif
    </div>
@endsection

@section('modals')
    @parent
    @includeWhen(auth()->check(), 'cruds.datagrids.bulks.modals')
@endsection

@section('og')
    <meta property="og:description" content="{{ __('seo.entity-list', ['module' => ($titleKey ?? __('entities.' . $langKey)), 'campaign' => $campaign->name]) }}" />
@endsection

