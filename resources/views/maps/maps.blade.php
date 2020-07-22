@extends('layouts.app', [
    'title' => trans('maps.maps.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('maps'), 'label' => __('maps.index.title')],
        ['url' => route('maps.show', $model), 'label' => $model->name],
        trans('maps.show.tabs.maps')
    ],
    'mainTitle' => false,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('maps._menu', ['active' => 'maps'])
        </div>
        <div class="col-md-9">
            @include('maps.panels.maps')
        </div>
    </div>
@endsection
