<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityFile $asset */
$assetCount = 0; ?>
@extends('layouts.app', [
    'title' => __('entities/assets.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-assets'
])
@inject('campaign', 'App\Services\CampaignService')

@section('entity-header-actions')
    @can('update', $entity->child)
        <div class="header-buttons">
            <a href="#" class="btn btn-warning btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_aliases.create', [$entity]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('entities/assets.actions.alias') }}
            </a>
            <a href="#" class="btn btn-warning btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_files.create', [$entity]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('entities/assets.actions.file') }}
            </a>
            <a href="#" class="btn btn-warning btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_links.create', [$entity]) }}">
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
                <div class="row entity-assets-row">
                    @foreach ($entity->assets() as $asset)
                        @if($assetCount % 3 == 0)
                </div><div class="row entity-assets-row">
                    @endif
                    @includeWhen($asset->isFile(), 'entities.pages.assets._file')
                    @includeWhen($asset->isLink(), 'entities.pages.assets._link')
                    @includeWhen($asset->isAlias(), 'entities.pages.assets._alias')

                    @php $assetCount++ @endphp
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
