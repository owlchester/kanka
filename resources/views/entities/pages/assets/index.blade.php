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

@section('entity-header-actions')
    @can('update', $entity->child)
        <div class="header-buttons inline-block flex flex-wrap gap-2 items-center justify-end">
            <a href="https://docs.kanka.io/en/latest/features/assets.html" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
            </a>
            @include('entities.pages.assets._buttons')
        </div>
    @endcan
@endsection

@section('content')
    @include('partials.errors')
    @include('partials.ads.top')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => \App\Facades\Module::plural($entity->typeId(), __('entities.' . $entity->pluralType()))],
                __('crud.tabs.assets')
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'assets',
            'model' => $entity->child,
        ])

        <div class="entity-main-block">
            @include('entities.pages.assets._asset')
        </div>
    </div>
@endsection
