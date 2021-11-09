<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/relations.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-relations'
])
@inject('campaign', 'App\Services\CampaignService')


@section('entity-header-actions')
        <div class="header-buttons">
            <div class="btn-group">
                <a href="{{ route('entities.relations.index', [$entity, 'mode' => 'table']) }}" class="btn btn-sm btn-default" data-toggle="tooltip" title="{{ __('entities/relations.actions.mode-table') }}">
                    <i class="fas fa-list-ul"></i>
                </a>
                <a href="{{ route('entities.relations.index', [$entity, 'mode' => 'map']) }}" class="btn btn-sm btn-default" data-toggle="tooltip" title="{{ __('entities/relations.actions.mode-map') }}">
                    <i class="fas fa-map"></i>
                </a>
            </div>

            @can('relation', [$entity->child, 'add'])
            <a href="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}" class="btn btn-sm btn-warning" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs hidden-sm">
                    {{ __('crud.relations.actions.add') }}
                </span>
            </a>
            @endcan
        </div>
@endsection



@section('content')
    @include('partials.errors')

    <div class="entity-grid">

        @include('entities.components.header_grid', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
                __('crud.tabs.connections')
            ]
        ])

        @include($entity->pluralType() . '._menu', [
            'active' => 'relations',
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">

            @includeWhen($mode == 'map' || (empty($mode) && $campaign->campaign()->boosted()), 'entities.pages.relations._map')
            @includeWhen($mode == 'table' || (empty($mode) && !$campaign->campaign()->boosted()), 'entities.pages.relations._relations')
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('js/relations.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/relations.css') }}" rel="stylesheet">
@endsection
