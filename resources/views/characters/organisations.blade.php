@extends('layouts.app', [
    'title' => __('characters.organisations.title', ['name' => $model->name]),
    'description' => __('characters.organisations.description'),
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
                ['url' => Breadcrumb::index('characters'), 'label' => __('characters.index.title')],
                null
            ]
        ])

        @include('characters._menu', ['active' => 'organisations'])

        <div class="entity-main-block">
            @include('characters.panels.organisations')
        </div>
    </div>
@endsection
