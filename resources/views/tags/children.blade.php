@extends('layouts.app', [
    'title' => __('tags.children.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'entities',
        'breadcrumb' => __('tags.show.tabs.children'),
        'view' => 'tags.panels.children',
        'entity' => $model->entity,
    ])
@endsection
