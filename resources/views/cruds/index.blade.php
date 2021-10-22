@extends('layouts.app', [
    'title' => __($langKey . '.index.title', ['name' => CampaignLocalization::getCampaign()->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => __($langKey . '.index.title')],
    ],
    'canonical' => true,
    'bodyClass' => 'kanka-' . $name,
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    <div class="row margin-bottom">
        <div class="col-md-12">
            @includeWhen($model->hasSearchableFields(), 'layouts.datagrid.search', ['route' => route($route . '.index')])

            @can('create', $model)
                <div class="btn-group pull-right">
                    <a href="{{ route($route . '.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">{{ __($langKey . '.index.add') }}</span>
                    </a>
                    @if(!in_array($name, ['menu_links', 'relations']))
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @if (!empty($templates) && !$templates->isEmpty())
                            @foreach ($templates as $entityTemplate)
                            <li>
                                <a href="{{ route($route . '.create', ['copy' => $entityTemplate->entity_id, 'template' => true]) }}">
                                    <i class="fa fa-star-o"></i> {{ $entityTemplate->name  }}</span>
                                </a>
                            </li>
                            @endforeach
                            <li class="divider"></li>
                            @endif
                            <li>
                                <a href="{{ route('helpers.entity-templates') }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('helpers.entity-templates') }}">
                                    <i class="fa fa-external-link"></i> {{ __('helpers.entity_templates.link') }}
                                </a>
                            </li>
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
                    <i class="fa fa-tree"></i> {{ __('crud.actions.explore_view') }}
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

            <div class="table-responsive">
                @include($name . '.datagrid')
            </div>
        </div>
        <div class="box-footer">

            @includeWhen(auth()->check() && $filteredCount > 0, 'cruds.datagrids.bulks.actions')

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

