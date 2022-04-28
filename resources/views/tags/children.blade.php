@extends('layouts.app', [
    'title' => __('tags.children.title', ['name' => $model->name]),
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
                ['url' => Breadcrumb::index('tags'), 'label' => __('tags.index.title')],
                __('tags.show.tabs.children')
            ]
        ])

        @include('tags._menu', ['active' => 'entities'])

        <div class="entity-main-block">
            @include('tags.panels.children')
        </div>
    </div>
@endsection
