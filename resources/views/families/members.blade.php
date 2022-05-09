@extends('layouts.app', [
    'title' => __('families.members.title', ['name' => $model->name]),
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
                null
            ]
        ])

        @include($name . '._menu', ['active' => 'members'])

        <div class="entity-main-block">
            @include('families.panels._members')
        </div>
    </div>
@endsection
