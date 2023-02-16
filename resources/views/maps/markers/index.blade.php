<?php /** @var \App\Models\Map $model */?>
@extends('layouts.app', [
    'title' => __('maps/markers.index.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])



@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons">
            <a href="https://docs.kanka.io/en/latest/entities/maps/markers.html" class="btn btn-default btn-sm" target="_blank">
                <i class="fa-solid fa-question-circle" aria-hidden="true"></i> {{ __('crud.actions.help') }}
            </a>
            @if ($model->explorable())
                <a href="{{ route('maps.explore', [$campaign, 'map' => $model]) }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-map" aria-hidden="true"></i>
                    {{ __('maps.actions.explore') }}
                </a>
            @endif
        </div>
    @endcan
@endsection

@section('content')
    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('maps'), 'label' => __('entities.maps')],
                __('maps.panels.markers')
            ]
        ])
        @include('maps._menu', ['active' => 'markers'])
        <div class="entity-main-block flex flex-col">
            @include('maps.form._markers', ['source' => null])
            @include('maps.panels.markers')
        </div>
    </div>
@endsection
