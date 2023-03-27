@extends('layouts.app', [
    'title' => __('entities.' . $langKey),
    'seoTitle' => __('entities.' . $langKey) . ' - ' . CampaignLocalization::getCampaign()->name,
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => __('entities.' . $langKey)],
    ],
    'canonical' => true,
    'bodyClass' => 'kanka-' . $name,
])
@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    <div class="mb-5 flex gap-2">
        <div class="grow">
            @include('layouts.datagrid.search', ['route' => route($name . '.index')])
        </div>
        <div>
            @include('cruds.lists._actions')
            @includeWhen(auth()->check() && auth()->user()->can('create', $model), 'cruds.lists._create')
        </div>
    </div>

    @include('partials.errors')

    @if ($filter)
        @include('cruds.datagrids.filters.datagrid-filter', ['route' => $route . '.tree'])
    @endif
    @include('partials.ads.top')

    <div class="box no-border">
        {!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
        <div class="box-body">
            @if (!empty($parent))
                <p class="help-block">{!! __('crud.helpers.nested_parent', ['parent' => $parent->tooltipedLink()]) !!}</p>
            @else
                <p class="help-block">{{ __($langKey . '.helpers.nested_without') }}</p>
            @endif
        </div>

        <div class="box-body no-padding">
            <div class="table-responsive">
                @include($name . '._tree')
            </div>

            @includeWhen($models->hasPages() && auth()->check() && !auth()->user()->settings()->get('tutorial_pagination'), 'cruds.helpers.pagination', ['action' => 'tree'])
        </div>
        <div class="box-footer">

            @includeWhen(auth()->check() && $filteredCount > 0, 'cruds.datagrids.bulks.actions')

            @if ($unfilteredCount != $filteredCount)
                <p class="help-block">
                    {{ __('crud.filters.filtered', ['count' => $filteredCount, 'total' => $unfilteredCount, 'entity' => __('entities.' . $name)]) }}
                </p>
            @endif
            <div class="pull-right">
                {{ $models->appends('parent_id', request()->get('parent_id'))->links() }}
            </div>
        </div>
        {!! Form::hidden('entity', $name) !!}
        {!! Form::hidden('datagrid-action', 'print') !!}
        {!! Form::hidden('page', request()->get('page')) !!}
        {!! Form::close() !!}
    </div>

    @includeWhen(auth()->check(), 'cruds.datagrids.bulks.modals')

    <input type="hidden" class="list-treeview" value="1" data-url="{{ route($route . '.tree') }}">
@endsection
