@extends('layouts.app', [
    'title' => trans('locations.maps.title', ['name' => $model->name]),
    'description' => trans('locations.maps.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('locations'), 'label' => __('locations.index.title')],
        ['url' => route('locations.show', $model), 'label' => $model->name],
        trans('locations.show.tabs.maps')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('locations._menu', ['active' => 'maps'])
        </div>
        <div class="col-md-9">
            @include('locations.panels.maps')
        </div>
    </div>
@endsection
