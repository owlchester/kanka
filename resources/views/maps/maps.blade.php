@php
    $plural = \App\Facades\Module::plural(config('entities.ids.map'), __('entities.maps'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' ' . $plural,
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('entity-header-actions')
    <div class="header-buttons inline-block pull-right ml-auto">
        @if (request()->has('map_id'))
            <a href="{{ route('maps.maps', [$model, '#map-maps']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants->count() }})
            </a>
        @else
            <a href="{{ route('maps.maps', [$model, 'map_id' => $model->id, '#map-maps']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.direct') }}</span>
                ({{ $model->maps->count() }})
            </a>
        @endif
    </div>
@endsection

@section('content')
    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('maps'), 'label' => $plural],
                $plural
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'maps'])

        <div class="entity-main-block">
            @include('maps.panels.maps')
        </div>
    </div>

@endsection
