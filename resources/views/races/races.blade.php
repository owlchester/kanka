@extends('layouts.app', [
    'title' => __('races.races.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
                null
            ]
        ])

        @include($name . '._menu', ['active' => 'races'])

        <div class="entity-main-block">
            @include('races.panels.races')
        </div>
    </div>
@endsection
