<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityAsset $asset */
?>
@extends('layouts.app', [
    'title' => __('entities/assets.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-assets'
])
@include('entities.components.og')

@section('entity-header-actions')
    @can('update', $entity->child)
        <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
            <a href="https://docs.kanka.io/en/latest/features/assets.html" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
            </a>
            @include('entities.pages.assets._buttons')
        </div>
    @endcan
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'assets',
        'breadcrumb' => __('crud.tabs.assets'),
        'view' => 'entities.pages.assets._assets',
        'entity' => $entity,
        'model' => $entity->child,
    ])
@endsection

@section('modals')
    @parent
    <x-dialog id="asset-dialog" :loading="true" />
@endsection
