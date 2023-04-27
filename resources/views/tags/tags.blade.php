@extends('layouts.app', [
    'title' => __('tags.tags.title', ['name' => $model->name]),
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
                ['url' => Breadcrumb::index('tags'), 'label' => \App\Facades\Module::plural(config('entities.ids.tag'), __('entities.tags')),
                __('entities.children')
            ]
        ])

        @include($name . '._menu', ['active' => 'tags'])

        <div class="entity-main-block">
            @include('tags.panels.tags')
        </div>
    </div>
@endsection
