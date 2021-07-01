@extends('layouts.app', [
    'title' => trans('locations.quests.title', ['name' => $model->name]),
    'description' => trans('locations.quests.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('locations'), 'label' => __('locations.index.title')],
        ['url' => route('locations.show', $model), 'label' => $model->name],
        trans('locations.show.tabs.quests')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('locations._menu', ['active' => 'quests'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('locations.panels.quests')
        </div>
    </div>
@endsection
