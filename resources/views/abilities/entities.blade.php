@extends('layouts.app', [
    'title' => __('abilities.entities.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('abilities'), 'label' => __('abilities.index.title')],
        ['url' => route('abilities.show', $model), 'label' => $model->name],
        __('abilities.show.tabs.entities')
    ],
    'mainTitle' => false,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('abilities._menu', ['active' => 'entities'])
        </div>
        <div class="col-md-9">
            @include('abilities.panels.entities')
        </div>
    </div>
@endsection
