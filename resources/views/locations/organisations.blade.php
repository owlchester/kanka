@extends('layouts.app', [
    'title' => trans('locations.organisations.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('locations._menu', ['active' => 'organisations'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('locations.panels.organisations')
        </div>
    </div>
@endsection
