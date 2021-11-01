@extends('layouts.app', [
    'title' => trans($name . '.index.title', ['name' => CampaignLocalization::getCampaign()->name]),
    'description' => null,
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
    ],
    'canonical' => true,
    'bodyClass' => 'kanka-' . $name,
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row margin-bottom">
        <div class="col-md-12">
            @include('layouts.datagrid.search', ['route' => route($name . '.tree')])

            @can('create', $model)
                <div class="btn-group pull-right">
                    <a href="{{ route($name . '.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">{{ trans($name . '.index.add') }}</span>
                    </a>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        @if (!empty($templates) && !$templates->isEmpty())
                        @foreach ($templates as $entityTemplate)
                            <li>
                                <a href="{{ route($name . '.create', ['copy' => $entityTemplate->entity_id, 'template' => true]) }}">
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
                </div>
            @endcan
            @foreach ($actions as $action)
                @if (empty($action['policy']) || (Auth::check() && Auth::user()->can($action['policy'], $model)))
                    <a href="{{ $action['route'] }}" class="btn pull-right btn-{{ $action['class'] }} margin-r-5">
                        {!! $action['label'] !!}
                    </a>
                @endif
            @endforeach
        </div>
    </div>

    @include('partials.errors')

    @if ($filter)
        @include('cruds.datagrids.filters.datagrid-filter', ['route' => $route . '.tree'])
    @endif

    <div class="box no-border">
        {!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
        <div class="box-body">
            @if (!empty($parent))
                <p class="help-block">{!! __($view . '.helpers.nested_parent', ['parent' => $parent->tooltipedLink()]) !!}</p>
            @else
                <p class="help-block">{{ __($view . '.helpers.nested_without') }}</p>
            @endif
        </div>

        <div class="box-body no-padding">
            <div class="table-responsive">
                @include($name . '._tree')
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
                {{ $models->appends('parent_id', request()->get('parent_id'))->links() }}
            </div>
        </div>
        {!! Form::hidden('entity', $name) !!}
        {!! Form::close() !!}
    </div>

    @include('cruds.datagrids.bulks.modals')

    <input type="hidden" class="list-treeview" id="{{ $view }}-treeview" value="1" data-url="{{ route($route . '.tree') }}">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/datagrids.js') }}" defer></script>
@endsection
