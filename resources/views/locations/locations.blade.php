@extends('layouts.app', [
    'title' => __('locations.locations.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header_grid', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('locations'), 'label' => __('locations.index.title')],
                __('locations.show.tabs.locations')
            ]
        ])

        @include('locations._menu', ['active' => 'locations'])

        <div class="entity-main-block">
            @include('locations.panels.locations')
        </div>
    </div>
@endsection
