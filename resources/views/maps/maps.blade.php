@extends('layouts.app', [
    'title' => trans('maps.maps.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('maps._menu', ['active' => 'maps'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('maps.panels.maps')
        </div>
    </div>
@endsection
