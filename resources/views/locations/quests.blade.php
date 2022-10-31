@extends('layouts.app', [
    'title' => __('locations.quests.title', ['name' => $model->name]),
    'description' => __('locations.quests.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('locations'), 'label' => __('entities.locations')],
        ['url' => route('locations.show', $model), 'label' => $model->name],
        __('locations.show.tabs.quests')
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
