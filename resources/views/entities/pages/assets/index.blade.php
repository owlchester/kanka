<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityAsset $asset */
?>
@extends('layouts.app', [
    'title' => __('entities/assets.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'bodyClass' => 'entity-assets'
])
@include('entities.components.og')

@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        @can('update', $entity)
            <x-learn-more url="features/assets.html" />
            @include('entities.pages.assets._buttons')
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'assets',
        'view' => 'entities.pages.assets._assets',
        'entity' => $entity,
    ])
@endsection

@section('modals')
    @parent
    <x-dialog id="asset-dialog" :loading="true" />
@endsection
