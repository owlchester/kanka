@extends('layouts.app', [
    'title' => $titleKey ?? __('entities.' . $langKey),
    'seoTitle' => $titleKey ?? __('entities.' . $langKey) . ' - ' . CampaignLocalization::getCampaign()->name,
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => $titleKey ?? __('entities.' . $langKey)],
    ],
    'canonical' => true,
    'bodyClass' => 'kanka-' . $name,
])
@inject('campaignService', 'App\Services\CampaignService')


@section('entity-header')
    <div class="flex items-center mb-2">
        <h1 class="grow m-0">{{ $titleKey ?? __('entities.' . $langKey) }}</h1>
        <div class="flex-0 flex gap-2">
            @includeWhen($route !== 'relations', 'layouts.datagrid._togglers', ['route' => 'index'])
            @include('cruds.lists._actions')
            @includeWhen(auth()->check() && auth()->user()->can('create', $model), 'cruds.lists._create')
        </div>
    </div>
@endsection

@section('content')
    @include('partials.errors')

    <div class="mb-3 flex flex-stretch gap-2 items-center">
        @includeWhen($model->hasSearchableFields(), 'layouts.datagrid.search', ['route' => route($route . '.index', ['m' => $mode])])
        @includeWhen(isset($filter) && $filter !== false, 'cruds.datagrids.filters.datagrid-filter', ['route' => $route . '.index'])
    </div>


    @include('partials.ads.top')

    @if (!isset($mode) || $mode === 'grid')
        @include('cruds.datagrids.explore', ['sub' => 'index'])
    @else
        <div class="box no-border">
            {!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
            <div class="box-body no-padding">

                <div class="table-responsive">
                    @include($name . '.datagrid')
                </div>

                @includeWhen($models->hasPages() && auth()->check() && !auth()->user()->settings()->get('tutorial_pagination'), 'cruds.helpers.pagination', ['action' => 'index'])
            </div>
            <div class="box-footer">
                @includeWhen(auth()->check() && $filteredCount > 0, 'cruds.datagrids.bulks.actions')

                @if ($unfilteredCount != $filteredCount)
                    <p class="help-block">
                        {{ __('crud.filters.filtered', ['count' => $filteredCount, 'total' => $unfilteredCount, 'entity' => __('entities.' . $name)]) }}
                    </p>
                @endif
                @if($models->hasPages())
                <div class="pull-right">
                    {{ $models->appends($filterService->pagination())->links() }}
                </div>
                @endif
                {!! Form::hidden('entity', $name) !!}
                {!! Form::hidden('datagrid-action', 'print') !!}
                {!! Form::hidden('page', request()->get('page')) !!}
                {!! Form::hidden('mode', $mode) !!}
            </div>
            {!! Form::close() !!}
        </div>
        @includeWhen(auth()->check(), 'cruds.datagrids.bulks.modals')

    @endif
@endsection


