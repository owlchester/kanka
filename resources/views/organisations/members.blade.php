@extends('layouts.app', [
    'title' => __('organisations.organisations.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('content')
    @include('entities.pages.subpage', [
        'active' => '',
        'breadcrumb' => '',
        'view' => 'organisations.panels.members',
    ])
@endsection

