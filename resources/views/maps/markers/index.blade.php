<?php /** @var \App\Models\Map $model */?>
@extends('layouts.app', [
    'title' => __('maps/markers.index.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @can('update', $entity)
            <a href="https://docs.kanka.io/en/latest/entities/maps/markers.html" class="btn2 btn-sm" target="_blank">
                <x-icon class="question" />
                <span class="hidden xl:inline">{{ __('crud.actions.help') }}</span>
            </a>
            @if ($model->explorable())
                <a href="{{ route('maps.explore', [$campaign, $model]) }}" class="btn2 btn-primary btn-sm">
                    <x-icon class="map" />
                    <span class="hidden xl:inline">{{ __('maps.actions.explore') }}</span>
                </a>
            @endif
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'markers',
        'breadcrumb' => __('maps.panels.markers'),
        'view' => 'maps.panels.markers',
    ])
@endsection
