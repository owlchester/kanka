@extends('layouts.app', [
    'title' => __('events.events.title', ['name' => $model->name]),
    'description' => __('events.events.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('events'), 'label' => __('events.index.title')],
        ['url' => route('events.show', $model), 'label' => $model->name],
        __('events.fields.events')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('events._menu', ['active' => 'events'])
        </div>
        <div class="col-md-9">
            @include('events.panels.events')
        </div>
    </div>
@endsection
