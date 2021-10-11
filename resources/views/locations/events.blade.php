@extends('layouts.app', [
    'title' => trans('locations.events.title', ['name' => $model->name]),
    'description' => trans('locations.events.description'),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('locations._menu', ['active' => 'events'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('locations.panels.events')
        </div>
    </div>
@endsection
