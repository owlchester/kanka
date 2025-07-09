<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . (request()->ajax() || request()->filled('dashboard') ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'bodyClass' => 'entity-attributes'
])

@include('entities.components.og')

@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        <x-learn-more url="features/attributes.html" />
        @can('attributes', [$entity])
            @include('entities.pages.attributes._buttons')
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'attributes',
        'view' => 'entities.pages.attributes.main',
        'entity' => $entity,
    ])
@endsection
