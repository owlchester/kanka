@php
$plural = \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    @include('characters.panels._buttons')
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'organisations',
        'breadcrumb' => $plural,
        'view' => 'organisations.panels.organisations',
        'entity' => $model->entity,
    ])
@endsection
