@extends('layouts.app', [
    'title' => __('abilities.abilities.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('abilities'), 'label' => __('entities.abilities')],
                __('abilities.show.tabs.abilities')
            ]
        ])

        @include('abilities._menu', ['active' => 'abilities'])

        <div class="entity-main-block">
            @include('abilities.panels.abilities')
        </div>
    </div>
@endsection
