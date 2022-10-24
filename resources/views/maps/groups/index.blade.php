@extends('layouts.app', [
    'title' => __('maps.maps.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons">
            <a href="https://docs.kanka.io/en/latest/entities/maps/groups.html" class="btn btn-default btn-sm" target="_blank">
                <i class="fa-solid fa-question-circle" aria-hidden="true"></i> {{ __('crud.actions.help') }}
            </a>
            @if ($model->explorable())
                <a href="{{ route('maps.explore', ['map' => $model]) }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-map" aria-hidden="true"></i>
                    {{ __('maps.actions.explore') }}
                </a>
            @endif
            <a href="{{ route('maps.map_groups.create', ['map' => $model]) }}" class="btn btn-warning btn-sm"
                data-toggle="ajax-modal" data-target="#entity-modal"
                data-url="{{ route('maps.map_groups.create', ['map' => $model]) }}"
            >
                <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('maps/groups.actions.add') }}
            </a>
        </div>
    @endcan
@endsection

@section('content')
    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('maps'), 'label' => __('maps.index.title')],
                __('maps.panels.groups')
            ]
        ])
        @include('maps._menu', ['active' => 'groups'])
        <div class="entity-main-block">
            @include('maps.panels.groups')
            @includeWhen($rows->count() > 1, 'maps.groups._reorder')
        </div>
    </div>
@endsection
