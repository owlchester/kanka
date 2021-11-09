@extends('layouts.app', [
    'title' => __('items.inventories.title', ['name' => $model->name]),
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
                ['url' => Breadcrumb::index('items'), 'label' => __('items.index.title')],
                null
            ]
        ])

        @include('items._menu', ['active' => 'inventories'])

        <div class="entity-main-block">
            @include('items.panels.inventories')
        </div>
    </div>
@endsection
