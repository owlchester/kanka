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
        <div class="header-buttons">
            <a href="#" class="btn btn-warning btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_ALIAS]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('entities/assets.actions.alias') }}
            </a>
            <a href="#" class="btn btn-warning btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_FILE]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('entities/assets.actions.file') }}
            </a>
            <a href="#" class="btn btn-warning btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_LINK]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('entities/assets.actions.link') }}
            </a>
        </div>
    @endcan
@endsection

@section('content')
    @include('partials.errors')
    @include('partials.ads.top')

    <div class="entity-grid">
        @include('entities.components.header_grid', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
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
                    @foreach ($assets as $asset)
                        @includeWhen($asset->isFile(), 'entities.pages.assets._file')
                        @includeWhen($asset->isLink(), 'entities.pages.assets._link')
                        @includeWhen($asset->isAlias(), 'entities.pages.assets._alias')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    @parent
    <link href="{{ mix('css/assets.css') }}" rel="stylesheet">
@endsection
