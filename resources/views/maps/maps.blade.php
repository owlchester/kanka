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
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants->count() }})
            </a>
        @else
            <a href="{{ route('maps.maps', [$model, 'map_id' => $model->id, '#map-maps']) }}" class="btn2 btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->maps->count() }})
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
