<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/relations.show.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.relations')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-relations'
])
@inject('campaign', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('relation', [$entity->child, 'add'])
        <div class="header-buttons">
            <div class="btn-group">
                <a href="{{ route('entities.relations.index', [$entity, 'mode' => 'table']) }}" class="btn btn-sm btn-default" data-toggle="tooltip" title="{{ __('entities/relations.actions.mode-table') }}">
                    <i class="fas fa-list-ul"></i>
                </a>
                <a href="{{ route('entities.relations.index', [$entity, 'mode' => 'map']) }}" class="btn btn-sm btn-default" data-toggle="tooltip" title="{{ __('entities/relations.actions.mode-map') }}">
                    <i class="fas fa-map"></i>
                </a>
            </div>

            <a href="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}" class="btn btn-sm btn-warning" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs hidden-sm">
                    {{ __('crud.relations.actions.add') }}
                </span>
            </a>
        </div>
    @endcan
@endsection

@include('entities.components.header', ['model' => $entity->child, 'entity' => $entity])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include($entity->pluralType() . '._menu', ['active' => 'relations', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>

        <div class="col-md-10 entity-main-block">
            @includeWhen($mode == 'map' || (empty($mode) && $campaign->campaign()->boosted()), 'entities.pages.relations._map')
            @includeWhen($mode == 'table' || (empty($mode) && !$campaign->campaign()->boosted()), 'entities.pages.relations._table')

        </div>
    </div>
@endsection
