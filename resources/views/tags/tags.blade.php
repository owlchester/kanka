@extends('layouts.app', [
    'title' => trans('tags.tags.title', ['name' => $model->name]),
    'description' => trans('tags.tags.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('tags'), 'label' => __('tags.index.title')],
        ['url' => route('tags.show', $model), 'label' => $model->name],
        trans('tags.show.tabs.tags')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include('tags._menu', ['active' => 'tags'])
        </div>
        <div class="col-md-10">
            @include('tags.panels.tags')
        </div>
    </div>
@endsection
