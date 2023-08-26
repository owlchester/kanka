@extends('layouts.app', [
    'title' => __('organisations.organisations.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('content')
    @include('entities.pages.subpage', [
        'active' => '',
        'breadcrumb' => '',
        'view' => 'organisations.panels.members',
        'entity' => $model->entity,
    ])
@endsection

