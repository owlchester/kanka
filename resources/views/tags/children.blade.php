@extends('layouts.app', [
    'title' => __('tags.children.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'entities',
        'view' => 'tags.panels.children',
    ])
@endsection
