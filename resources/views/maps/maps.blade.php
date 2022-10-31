@extends('layouts.app', [
    'title' => __('maps.maps.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('maps'), 'label' => __('entities.maps')],
                null
            ]
        ])

        @include('maps._menu', ['active' => 'maps'])

        <div class="entity-main-block">
            @include('maps.panels.maps')
        </div>
    </div>

@endsection
