@extends('layouts.app', [
    'title' => __('creatures.creatures.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.creature'), __('entities.creatures'));
@endphp
@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('creatures'), 'label' => $plural],
                $plural
            ]
        ])

        @include($name . '._menu', ['active' => 'creatures'])

        <div class="entity-main-block">
            @include('creatures.panels.creatures')
        </div>
    </div>
@endsection
