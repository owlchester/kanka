@extends('layouts.app', [
    'title' => trans('abilities.abilities.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('abilities'), 'label' => __('abilities.index.title')],
        ['url' => route('abilities.show', $model), 'label' => $model->name],
        trans('abilities.show.tabs.abilities')
    ],
    'mainTitle' => false,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('abilities._menu', ['active' => 'abilities'])
        </div>
        <div class="col-md-9">
            @include('abilities.panels.abilities')
        </div>
    </div>
@endsection
