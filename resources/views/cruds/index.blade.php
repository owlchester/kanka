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


@section('content')
    <div class="mb-5 flex gap-2">
        <div class="grow">
            @includeWhen($model->hasSearchableFields(), 'layouts.datagrid.search', ['route' => route($route . '.index')])
        </div>
        <div>
            @include('cruds.lists._actions')
            @includeWhen(auth()->check() && auth()->user()->can('create', $model), 'cruds.lists._create')
        </div>
    </div>

    @include('partials.errors')

    @includeWhen(isset($filter) && $filter !== false, 'cruds.datagrids.filters.datagrid-filter', ['route' => $route . '.index'])
    @include('partials.ads.top')

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
        </div>
        {!! Form::close() !!}
    </div>


    @includeWhen(auth()->check(), 'cruds.datagrids.bulks.modals')
@endsection


