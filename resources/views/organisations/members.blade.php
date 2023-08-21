@extends('layouts.app', [
    'title' => __('organisations.organisations.title', ['name' => $model->name]),
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
                Breadcrumb::entity($model->entity)->list(),
                null
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'members'])

        <div class="entity-main-block">
            @include('organisations.panels.members')
        </div>
    </div>
@endsection

