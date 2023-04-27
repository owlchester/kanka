@extends('layouts.app', [
    'title' => __('abilities.abilities.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.ability'), __('entities.abilities'));
@endphp
@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('abilities'), 'label' => $plural],
                $plural
            ]
        ])

        @include('abilities._menu', ['active' => 'abilities'])

        <div class="entity-main-block">
            @include('abilities.panels.abilities')
        </div>
    </div>
@endsection
