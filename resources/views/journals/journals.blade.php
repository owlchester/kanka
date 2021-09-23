@extends('layouts.app', [
    'title' => trans('journals.journals.title', ['name' => $model->name]),
    'description' => trans('journals.journals.description'),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('journals._menu', ['active' => 'journals'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('journals.panels.journals')
        </div>
    </div>
@endsection
