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
    <div class="row">
        <div class="col-md-3">
            @include('calendars._menu', ['active' => 'events'])
        </div>
        <div class="col-md-9">
            @include('calendars.panels.events')
        </div>
    </div>
@endsection
