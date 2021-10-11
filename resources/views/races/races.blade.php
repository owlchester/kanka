@extends('layouts.app', [
    'title' => __('races.races.title', ['name' => $model->name]),
    'description' => __('races.races.description'),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('races._menu', ['active' => 'races'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('races.panels.races')
        </div>
    </div>
@endsection
