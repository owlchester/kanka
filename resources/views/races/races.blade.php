@extends('layouts.app', [
    'title' => __('races.races.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races'));
@endphp
@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('races'), 'label' => $plural],
                __('entities.children')
            ]
        ])

        @include($name . '._menu', ['active' => 'races'])

        <div class="entity-main-block">
            @include('races.panels.races')
        </div>
    </div>
@endsection
