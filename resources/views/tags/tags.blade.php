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
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($name), 'label' => __('entities.' . $name)],
                null
            ]
        ])

        @include($name . '._menu', ['active' => 'tags'])

        <div class="entity-main-block">
            @include('tags.panels.tags')
        </div>
    </div>
@endsection
