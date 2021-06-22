@extends('layouts.app', [
    'title' => trans('locations.journals.title', ['name' => $model->name]),
    'description' => trans('locations.journals.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('locations'), 'label' => __('locations.index.title')],
        ['url' => route('locations.show', $model), 'label' => $model->name],
        trans('locations.show.tabs.journals')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('locations._menu', ['active' => 'journals'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('locations.panels.journals')
        </div>
    </div>
@endsection
