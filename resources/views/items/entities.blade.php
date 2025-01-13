@extends('layouts.app', [
    'title' => $entity->name . ' - ' . __('items.show.tabs.inventories'),
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'inventories',
        'breadcrumb' => __('items.show.tabs.inventories'),
        'view' => 'items.panels.entities',
    ])
@endsection
