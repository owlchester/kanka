@extends('layouts.app', [
    'title' => $entity->name . ' - ' . __('items.show.tabs.inventories'),
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@dd('why')

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'inventories',
        'view' => 'items.panels.inventories',
    ])
@endsection
