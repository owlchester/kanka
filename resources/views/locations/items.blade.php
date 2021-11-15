@extends('layouts.app', [
    'title' => __('locations.items.title', ['name' => $model->name]),
    'breadcrumbs' => false,
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
                __('locations.show.tabs.items')
            ]
        ])

        @include('locations._menu', ['active' => 'items'])

        <div class="entity-main-block">
            @include('locations.panels.items')
        </div>
    </div>
@endsection
