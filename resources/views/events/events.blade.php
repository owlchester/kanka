@extends('layouts.app', [
    'title' => __('events.events.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.event'), __('entities.events'));
@endphp
@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('events'), 'label' => $plural],
                $plural
            ]
        ])

        @include('events._menu', ['active' => 'events'])

        <div class="entity-main-block">
            @include('events.panels.events')
        </div>
    </div>
@endsection

