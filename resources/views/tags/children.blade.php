@extends('layouts.app', [
    'title' => trans('tags.children.title', ['name' => $model->name]),
    'description' => trans('tags.children.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('tags'), 'label' => __('tags.index.title')],
        ['url' => route('tags.show', $model), 'label' => $model->name],
        trans('tags.show.tabs.children')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('tags._menu', ['active' => 'children'])
        </div>
        <div class="col-md-9">
            @include('tags.panels.children')
        </div>
    </div>
@endsection
