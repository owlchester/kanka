@extends('layouts.app', [
    'title' => __('timelines.timelines.title', ['name' => $model->name]),
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
                ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
                __('timelines.fields.timelines')
            ]
        ])

        @include($name . '._menu', ['active' => 'timelines'])

        <div class="entity-main-block">
            @include('timelines.panels.timelines')
        </div>
    </div>
@endsection
