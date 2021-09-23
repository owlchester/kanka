@extends('layouts.app', [
    'title' => __('events.events.title', ['name' => $model->name]),
    'description' => __('events.events.description'),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('events._menu', ['active' => 'events'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('events.panels.events')
        </div>
    </div>
@endsection
