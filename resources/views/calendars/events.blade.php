@extends('layouts.app', [
    'title' => __('calendars.events.title', ['name' => $model->name]),
    'description' => __('calendars.events.description'),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header_grid', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
                null
            ]
        ])

        @include($name . '._menu', ['active' => 'events'])

        <div class="entity-main-block">
            @include('calendars.panels.events')
        </div>
    </div>
@endsection
