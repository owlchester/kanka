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
            <a href="https://docs.kanka.io/en/latest/entities/maps/groups.html" class="btn btn-default" target="_blank">
                <i class="fa-solid fa-question-circle" aria-hidden="true"></i> {{ __('crud.actions.help') }}
            </a>
            <a href="{{ route('maps.map_groups.create', ['map' => $model]) }}" class="btn btn-warning"
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
                null
            ]
        ])
        @include('maps._menu', ['active' => 'groups'])
        <div class="entity-main-block">
            @include('maps.panels.groups')
            @includeWhen($rows->count() > 1, 'maps.groups._reorder')
        </div>
    </div>
@endsection
