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
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('locations._menu', ['active' => 'maps'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('locations.panels.maps')
        </div>
    </div>
@endsection
