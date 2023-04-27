@extends('layouts.app', [
    'title' => __('maps.maps.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.map'), __('entities.maps'));
@endphp
@section('content')
    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('maps'), 'label' => $plural],
                __('entities.children')
            ]
        ])

        @include('maps._menu', ['active' => 'maps'])

        <div class="entity-main-block">
            @include('maps.panels.maps')
        </div>
    </div>

@endsection
