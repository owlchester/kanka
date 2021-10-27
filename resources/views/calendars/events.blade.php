@extends('layouts.app', [
    'title' => __('calendars.events.title', ['name' => $model->name]),
    'description' => __('calendars.events.description'),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('calendars._menu', ['active' => 'events'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('calendars.panels.events')
        </div>
    </div>
@endsection
