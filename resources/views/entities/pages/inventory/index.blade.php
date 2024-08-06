<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-inventory',
])

@include('entities.components.og')

@section('entity-header-actions')
    @can('inventory', $entity->child)
        <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
            <a href="https://docs.kanka.io/en/latest/features/inventory.html" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question" /> {{ __('crud.actions.help') }}
            </a>
            @include('entities.pages.inventory._buttons')
        </div>
    @endcan
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'inventory',
        'breadcrumb' => __('crud.tabs.inventory'),
        'view' => 'entities.pages.inventory.render',
        'entity' => $entity,
        'model' => $entity->child,
    ])
@endsection
