@extends('layouts.app', [
    'title' => __('organisations.organisations.title', ['name' => $model->name]),
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
                ['url' => Breadcrumb::index('organisations'), 'label' => \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'))],
                null
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'members'])

        <div class="entity-main-block">
            @include('organisations.panels.members')
        </div>
    </div>
@endsection

