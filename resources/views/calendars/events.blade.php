@extends('layouts.app', [
    'title' => trans('calendars.events.title', ['name' => $model->name]),
    'description' => trans('calendars.events.description'),
    'breadcrumbs' => [
        ['url' => route('calendars.index'), 'label' => __('calendars.index.title')],
        ['url' => route('calendars.show', $model), 'label' => $model->name],
        trans('calendars.show.tabs.events')
    ],
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
