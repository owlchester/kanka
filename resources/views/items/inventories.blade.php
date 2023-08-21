@extends('layouts.app', [
    'title' => $model->name . ' - ' . __('items.show.tabs.inventories'),
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
                __('items.show.tabs.inventories')
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'inventories'])

        <div class="entity-main-block">
            @include('items.panels.inventories')
        </div>
    </div>
@endsection
