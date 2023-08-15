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
        <div class="header-buttons flex gap-2 items-center justify-end">
            <a href="https://docs.kanka.io/en/latest/entities/maps/markers.html" class="btn2 btn-sm" target="_blank">
                <x-icon class="question" />
                {{ __('crud.actions.help') }}
            </a>
            @if ($model->explorable())
                <a href="{{ route('maps.explore', [$campaign, $model]) }}" class="btn2 btn-primary btn-sm">
                    <x-icon class="map" />
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
                Breadcrumb::entity($model->entity)->list(),
                __('maps.panels.markers')
            ]
        ])
        @include('entities.components.menu_v2', ['active' => 'markers'])
        <div class="entity-main-block flex flex-col">
            @include('maps.form._markers', ['source' => null])
            @include('maps.panels.markers')
        </div>
    </div>
@endsection
