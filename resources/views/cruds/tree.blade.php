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
    <div class="row mb-5">
        <div class="col-md-12">
            @include('layouts.datagrid.search', ['route' => route($name . '.tree')])

            @can('create', $model)
                <div class="btn-group pull-right">
                    <a href="{{ route($name . '.create') }}" class="btn btn-primary btn-new-entity" data-entity-type="{{ $name }}">
                        <i class="fa-solid fa-plus"></i>
                        <span class="hidden-xs hidden-sm">{{ __('entities.' .  \Illuminate\Support\Str::singular($route)) }}</span>
                    </a>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        @if ($templates->isNotEmpty())
                        @foreach ($templates as $entityTemplate)
                            <li>
                                <a href="{{ route($name . '.create', ['copy' => $entityTemplate->entity_id, 'template' => true]) }}" class="new-entity-from-template" data-entity-type="{{ $name }}">
                                    <i class="fa-solid fa-star"></i> {{ $entityTemplate->name  }}</span>
                                </a>
                            </li>
                        @endforeach
                            <li class="divider"></li>
                        @endif
                        <li>
                            <a href="//docs.kanka.io/en/latest/guides/templates.html" target="_blank">
                                <i class="fa-solid fa-external-link"></i> {{ __('helpers.entity_templates.link') }}
                            </a>
                        </li>
                    </ul>
                </div>
            @endcan
            @foreach ($actions as $action)
                @if (empty($action['policy']) || (Auth::check() && Auth::user()->can($action['policy'], $model)))
                    <a href="{{ $action['route'] }}" class="btn pull-right btn-{{ $action['class'] }} mr-2">
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
    @include('partials.ads.top')

    <div class="box no-border">
        {!! Form::open(['url' => route('bulk.process', [$campaign]), 'method' => 'POST']) !!}
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
