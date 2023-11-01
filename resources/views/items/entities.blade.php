@extends('layouts.app', [
    'title' => $model->name . ' - ' . __('items.show.tabs.inventories'),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'inventories',
        'breadcrumb' => __('items.show.tabs.inventories'),
        'view' => 'items.panels.entities',
        'entity' => $model->entity,
    ])
@endsection
