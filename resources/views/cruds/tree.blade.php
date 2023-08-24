@extends('layouts.app', [
    'title' => $titleKey ?? __('entities.' . $langKey),
    'seoTitle' => $titleKey ?? __('entities.' . $langKey) . ' - ' . $campaign->name,
    'breadcrumbs' => false,
    'canonical' => true,
    'bodyClass' => 'kanka-' . $name,
])

@section('entity-header')
    <div class="flex items-center mb-2">
        <h1 class="grow m-0 text-4xl category-title">{!! $titleKey ?? __('entities.' . $langKey) !!}</h1>
        <div class="flex-none flex gap-2">
            @include('layouts.datagrid._togglers', ['route' => 'tree'])
            @include('cruds.lists._actions')
            @includeWhen(auth()->check() && auth()->user()->can('create', $model), 'cruds.lists._create')
        </div>
    </div>
@endsection

@section('content')

    @include('partials.errors')

    @if (auth()->guest())
        <div class="text-muted grow mb-5">
            <i class="fa-solid fa-filter" aria-hidden="true"></i>
            {{ __('filters.helpers.guest') }}
        </div>
    @else
    <div class="mb-3 flex flex-stretch gap-2 items-center">
        @includeWhen($model->hasSearchableFields(), 'layouts.datagrid.search', ['route' => route($route . '.index', $campaign)])
        @includeWhen(isset($filter) && $filter !== false, 'cruds.datagrids.filters.datagrid-filter', ['route' => $route . '.index'])
    </div>
    @endif

    @include('partials.ads.top')

    @if (!isset($mode) || $mode === 'grid')
        @include('cruds.datagrids.explore', ['nested' => true, 'sub' => 'tree'])
    @else
        {!! Form::open(['url' => route('bulk.process', $campaign), 'method' => 'POST']) !!}
        <x-box :padding="false">
            <div class="table-responsive">
                @include($name . '._tree')
            </div>
        </x-box>

        @includeWhen($models->hasPages() && auth()->check(), 'cruds.helpers.pagination', ['action' => 'tree'])

        @includeWhen(auth()->check() && $filteredCount > 0, 'cruds.datagrids.bulks.actions')

        @if ($unfilteredCount != $filteredCount)
            <p class="help-block">
                {{ __('crud.filters.filtered', ['count' => $filteredCount, 'total' => $unfilteredCount, 'entity' => __('entities.' . $name)]) }}
            </p>
        @endif
        @if($models->hasPages())
        <div class="pull-right">
            {{ $models->appends('parent_id', request()->get('parent_id'))->appends('m', 'table')->onEachSide(0)->links() }}
        </div>
        @endif
        {!! Form::hidden('entity', $name) !!}
        {!! Form::hidden('datagrid-action', 'print') !!}
        {!! Form::hidden('page', request()->get('page')) !!}
        {!! Form::hidden('mode', $mode) !!}
        {!! Form::close() !!}

    @endif

    <input type="hidden" class="list-treeview" value="1" data-url="{{ route($route . '.tree', $campaign) }}">
@endsection

@section('modals')
    @parent
    @includeWhen(auth()->check(), 'cruds.datagrids.bulks.modals')
@endsection
