@extends('layouts.app', [
    'title' => __('events.events.title', ['name' => $model->name]),
    'breadcrumbs' => false,
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
                ['url' => Breadcrumb::index('events'), 'label' => __('events.index.title')],
                __('events.show.tabs.events')
            ]
        ])

        @include('events._menu', ['active' => 'events'])

        <div class="entity-main-block">
            @include('events.panels.events')
        </div>
    </div>
@endsection

