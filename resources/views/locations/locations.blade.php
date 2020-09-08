@extends('layouts.app', [
    'title' => trans('locations.locations.title', ['name' => $model->name]),
    'description' => trans('locations.locations.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('locations'), 'label' => __('locations.index.title')],
        ['url' => route('locations.show', $model), 'label' => $model->name],
        trans('locations.show.tabs.locations')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('locations._menu', ['active' => 'locations'])
        </div>
        <div class="col-md-9">
            @include('locations.panels.locations')
        </div>
    </div>
@endsection
