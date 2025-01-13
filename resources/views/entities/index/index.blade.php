@extends('layouts.app', [
    'title' => $entityType->plural(),
    'seoTitle' => $entityType->plural() . ' - ' . $campaign->name,
    'breadcrumbs' => false,
    'canonical' => true,
    'bodyClass' => 'kanka-' . $entityType->code,
])

@section('entity-header')
    <div class="flex gap-2 items-center mb-5">
        <h1 class="grow text-4xl category-title truncate">{!! $entityType->plural() !!}</h1>
        <div class="flex flex-wrap gap-2 justify-end">
            @include('layouts.datagrid._togglers', ['route' => 'index'])
            @includeWhen(isset($actions), 'entities.index._actions')
            @can('create', [$entityType, $campaign])
                @include('entities.index._create')
            @endcan
        </div>
    </div>
@endsection

@section('content')
    @include('partials.errors')

    @include('ads.top')

    <div class="flex flex-col gap-5">
    @if (auth()->guest())
        <div class="text-muted grow">
            <x-icon class="fa-solid fa-filter" />
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

    @if (!isset($mode) || $mode === 'grid')
        @include('cruds.datagrids.explore', ['route' => $route . '.index'])
    @else
        <x-form class="flex flex-col gap-5" :action="['bulk.print', [$campaign, 'entity_type' => $entityType]]" direct>
            @include('cruds._table')
            <input type="hidden" name="page" value="{{ request()->get('page') }}" />
        </x-form>
        <input type="hidden" class="list-treeview" value="1" data-url="{{ route($route . '.index', $campaign) }}">
    @endif
    </div>
@endsection

@section('modals')
    @parent
    @includeWhen(auth()->check(), 'cruds.datagrids.bulks.modals')
@endsection


