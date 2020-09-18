@extends('layouts.app', [
    'title' => trans($name . '.index.title', ['name' => CampaignLocalization::getCampaign()->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => trans($name . '.index.title')],
    ],
    'canonical' => true,
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    <div class="row margin-bottom">
        <div class="col-md-12">
            @include('layouts.datagrid.search', ['route' => route($name . '.index')])

            @can('create', $model)
                <div class="btn-group pull-right">
                    <a href="{{ route($name . '.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">{{ trans($name . '.index.add') }}</span>
                    </a>
                    @if(!empty($templates) && !$templates->isEmpty())
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ($templates as $entityTemplate)
                            <li>
                                <a href="{{ route($name . '.create', ['copy' => $entityTemplate->entity_id]) }}">
                                    <i class="fa fa-star-o"></i> {{ $entityTemplate->name  }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endcan
            @foreach ($actions as $action)
                @if (empty($action['policy']) || (Auth::check() && Auth::user()->can($action['policy'], $model)))
                    <a href="{{ $action['route'] }}" class="btn pull-right btn-{{ $action['class'] }} margin-r-5">
                        {!! $action['label'] !!}
                    </a>
                @endif
            @endforeach

            @if (!empty($nestedView) && $nestedView)
                <a href="{{ route($route . '.tree') }}" class="btn pull-right btn-default margin-r-5">
                    <i class="fa fa-tree"></i> {{ trans('crud.actions.explore_view') }}
                </a>
            @endif
        </div>
    </div>

    @include('partials.errors')

    @if ($filter)
        @include('cruds.datagrids.filters.datagrid-filter', ['route' => $route . '.index'])
    @endif

    <div class="box no-border">
        {!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
        <div class="box-body no-padding">

            @include($name . '.datagrid')
        </div>
        <div class="box-footer">

            @include('cruds.datagrids.bulks.actions')

            @if ($unfilteredCount != $filteredCount)
                <p class="help-block">
                    {{ __('crud.filters.filtered', ['count' => $filteredCount, 'total' => $unfilteredCount, 'entity' => __('entities.' . $name)]) }}
                </p>
            @endif
            <div class="pull-right">
                {{ $models->appends($filterService->pagination())->links() }}
            </div>
            {!! Form::hidden('entity', $name) !!}
            {!! Form::hidden('page', request()->get('page')) !!}
        </div>
        {!! Form::close() !!}
    </div>


    @include('cruds.datagrids.bulks.modals')
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/datagrids.js') }}" defer></script>
@endsection

