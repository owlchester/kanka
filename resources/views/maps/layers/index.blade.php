<?php /** @var \App\Models\Map $model */?>
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
            <a href="https://docs.kanka.io/en/latest/entities/maps/layers.html" class="btn btn-default btn-sm" target="_blank">
                <i class="fa-solid fa-question-circle" aria-hidden="true"></i> {{ __('crud.actions.help') }}
            </a>
            @if ($model->explorable())
                <a href="{{ route('maps.explore', ['map' => $model]) }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-map" aria-hidden="true"></i>
                    {{ __('maps.actions.explore') }}
                </a>
            @endif
            <a href="{{ route('maps.map_layers.create', ['map' => $model]) }}" class="btn btn-warning btn-sm"
                data-url="{{ route('maps.map_layers.create', ['map' => $model]) }}"
            >
            <i class="fa-solid fa-plus"></i> {{ __('maps/layers.actions.add') }}
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
                __('maps.panels.layers')
            ]
        ])
        @include('maps._menu', ['active' => 'layers'])
        <div class="entity-main-block">
            @include('maps.panels.layers')
            @includeWhen($rows->count() > 1, 'maps.layers._reorder')
        </div>
    </div>
@endsection
