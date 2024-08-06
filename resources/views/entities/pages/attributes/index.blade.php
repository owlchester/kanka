<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . (request()->ajax() || request()->filled('dashboard') ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-attributes'
])

@include('entities.components.og')

@section('entity-header-actions')
    @can('attribute', [$entity->child, 'add'])
        <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
            <a href="https://docs.kanka.io/en/latest/features/attributes.html" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question" /> {{ __('crud.actions.help') }}
            </a>
            @include('entities.pages.attributes._buttons')
        </div>
    @endcan
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'attributes',
        'breadcrumb' => __('crud.tabs.attributes'),
        'view' => 'entities.pages.attributes.main',
        'entity' => $entity,
        'model' => $entity->child,
    ])
@endsection
