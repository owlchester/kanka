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
            @includeWhen($model->hasSearchableFields(), 'layouts.datagrid.search', ['route' => route($route . '.index')])

            @can('create', $model)
                <div class="btn-group pull-right">
                    <a href="{{ route($route . '.create') }}" class="btn btn-primary btn-new-entity" data-entity-type="{{ $name }}">
                        <i class="fa-solid fa-plus"></i> <span class="hidden-xs hidden-sm">{{ __('entities.' .  \Illuminate\Support\Str::singular($route)) }}</span>
                    </a>
                    @if(!in_array($name, ['menu_links', 'relations']))
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @if ($templates->isNotEmpty())
                            @foreach ($templates as $entityTemplate)
                            <li>
                                <a href="{{ route($route . '.create', ['copy' => $entityTemplate->entity_id, 'template' => true]) }}" class="new-entity-from-template" data-entity-type="{{ $name }}">
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
                    @endif
                </div>
            @endcan
            @foreach ($actions as $action)
                @if (empty($action['policy']) || (auth()->check() && auth()->user()->can($action['policy'], $model)))
                    <a href="{{ $action['route'] }}" class="btn pull-right btn-{{ $action['class'] }} mr-2" @if ($action['blank'])target="_blank"@endif>
                        {!! $action['label'] !!}
                    </a>
                @endif
            @endforeach
        </div>
    </div>

    @include('partials.errors')

    @includeWhen(isset($filter), 'cruds.datagrids.filters.datagrid-filter', ['route' => $route . '.index'])
    @include('partials.ads.top')

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


