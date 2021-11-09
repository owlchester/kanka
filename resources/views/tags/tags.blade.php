@extends('layouts.app', [
    'title' => trans('tags.tags.title', ['name' => $model->name]),
    'description' => trans('tags.tags.description'),
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
                ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
                null
            ]
        ])

        @include($name . '._menu', ['active' => 'tags'])

        <div class="entity-main-block">
            @include('tags.panels.tags')
        </div>
    </div>
@endsection
