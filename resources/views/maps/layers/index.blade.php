<?php /** @var \App\Models\Map $model */?>
@extends('layouts.app', [
    'title' => __('maps/layers.index.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @can('update', $entity)
            <a href="https://docs.kanka.io/en/latest/entries/maps/layers.html" class="btn2 btn-sm" target="_blank">
                <x-icon class="question" />
                <span class="hidden xl:inline">{{ __('crud.actions.help') }}</span>
            </a>
            @if ($model->explorable())
                <a href="{{ route('maps.explore', [$campaign, $model]) }}" class="btn2 btn-primary btn-sm">
                    <x-icon class="map" />
                    <span class="hidden xl:inline">{{ __('maps.actions.explore') }}</span>
                </a>
            @endif
            <a href="{{ route('maps.map_layers.create', [$campaign, $model]) }}" class="btn2 btn-sm"
                data-url="{{ route('maps.map_layers.create', [$campaign, $model]) }}"
            >
                <x-icon class="plus" />
                <span class="hidden xl:inline">{{ __('maps/layers.actions.add') }}</span>
            </a>
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'layers',
        'view' => 'maps.panels.layers',
    ])
@endsection
