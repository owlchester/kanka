<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-relations'
])
@inject('campaignService', 'App\Services\CampaignService')


@section('entity-header-actions')
        <div class="header-buttons inline-block pull-right ml-auto">
            <div class="btn-group">
                <a href="{{ route('entities.relations.index', [$entity, 'mode' => 'table']) }}" class="btn btn-sm btn-default" data-toggle="tooltip" title="{{ __('entities/relations.actions.mode-table') }}">
                    <i class="fa-solid fa-list-ul" aria-hidden="true"></i>
                </a>
                <a href="{{ route('entities.relations.index', [$entity, 'mode' => 'map']) }}" class="btn btn-sm btn-default" data-toggle="tooltip" title="{{ __('entities/relations.actions.mode-map') }}">
                    <x-icon class="map"></x-icon>
                </a>
            </div>

            @can('relation', [$entity->child, 'add'])
            <a href="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}" class="btn btn-sm btn-warning" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}">
                <x-icon class="plus"></x-icon>
                <span class="hidden-xs hidden-sm">
                    {{ __('entities.relation') }}
                </span>
            </a>
            @endcan
        </div>
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
                __('crud.tabs.connections')
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'relations',
            'model' => $entity->child,
        ])

        <div class="entity-main-block">

            @includeWhen($mode == 'map' || (empty($mode) && $campaignService->campaign()->boosted()), 'entities.pages.relations._map')
            @includeWhen($mode == 'table' || (empty($mode) && !$campaignService->campaign()->boosted()), 'entities.pages.relations._relations')
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/relations.js')
@endsection

@section('styles')
    @vite('resources/sass/relations.scss')
@endsection
