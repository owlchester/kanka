@extends('layouts.app', [
    'title' => __('families/trees.title', ['name' => $family->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'tree',
        'breadcrumb' => __(''),
        'view' => 'families.panels.tree',
        'entity' => $family->entity,
        'model' => $family,
    ])
@endsection


