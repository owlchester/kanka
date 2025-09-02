@extends('layouts.app', [
    'title' =>  $entity->name . ' ' . __('organisations.fields.members'),
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'members',
        'view' => 'organisations.panels.members',
    ])
@endsection

