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
@inject('campaignService', 'App\Services\CampaignService')

@section('entity-header-actions')
    @can('update', $entity->child)
        <div class="header-buttons inline-block pull-right ml-auto">
            <a href="#" class="btn btn-warning btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_ALIAS]) }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('entities/assets.actions.alias') }}
            </a>
            <a href="#" class="btn btn-warning btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_FILE]) }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('entities/assets.actions.file') }}
            </a>
            <a href="#" class="btn btn-warning btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_LINK]) }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('entities/assets.actions.link') }}
            </a>
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

        @include($entity->pluralType() . '._menu', [
            'active' => 'assets',
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">

            <div class="entity-assets">
                <div class="grid grid-cols-3 gap-2 entity-assets-row">
                    @forelse ($assets as $asset)
                        @includeWhen($asset->isFile(), 'entities.pages.assets._file')
                        @includeWhen($asset->isLink(), 'entities.pages.assets._link')
                        @includeWhen($asset->isAlias(), 'entities.pages.assets._alias')
                    @empty
                        @can('update', $entity->child)
                            <a href="#" class="btn btn-app py-5 flex flex-col gap-3" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_ALIAS]) }}">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('entities/assets.actions.alias') }}
                            </a>
                            <a href="#" class="btn btn-app py-5 flex flex-col gap-3" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_FILE]) }}">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('entities/assets.actions.file') }}
                            </a>
                            <a href="#" class="btn btn-app py-5 flex flex-col gap-3" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_LINK]) }}">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('entities/assets.actions.link') }}
                            </a>
                        @endcan
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
