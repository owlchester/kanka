@extends('layouts.app', [
    'title' => $model->name . ' - ' . __('items.show.tabs.inventories'),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@dd('why')

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'inventories',
        'breadcrumb' => __('items.show.tabs.inventories'),
        'view' => 'items.panels.inventories',
        'entity' => $model->entity,
    ])
@endsection
