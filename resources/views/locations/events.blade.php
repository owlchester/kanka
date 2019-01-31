@extends('layouts.app', [
    'title' => trans('locations.events.title', ['name' => $model->name]),
    'description' => trans('locations.events.description'),
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => __('locations.index.title')],
        ['url' => route('locations.show', $model), 'label' => $model->name],
        trans('locations.show.tabs.events')
    ]
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('locations._menu', ['active' => 'events'])
        </div>
        <div class="col-md-9">
            @include('locations.panels.events')
        </div>
    </div>
@endsection
