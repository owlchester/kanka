<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-inventory'
])
@inject('campaign', 'App\Services\CampaignService')



@section('entity-header-actions')
    @can('inventory', $entity->child)
        <div class="header-buttons">
            <a href="{{ route('entities.inventories.create', ['entity' => $entity]) }}" class="btn btn-warning btn-sm"
               data-toggle="ajax-modal" data-target="#entity-modal"
               data-url="{{ route('entities.inventories.create', ['entity' => $entity]) }}"
            >
                <i class="fa fa-plus"></i>
                {{ __('entities/inventories.actions.add') }}
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
                __('crud.tabs.inventory')
            ]
        ])

        @include($entity->pluralType() . '._menu', [
            'active' => 'inventory',
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">
            <div class="box box-solid box-entity-inventory">
                <div class="box-body">
                    @if ($inventory->count() === 0)
                        <p class="help-block">{{ __('entities/inventories.show.helper') }}</p>
                        <a href="{{ route('entities.inventories.create', ['entity' => $entity]) }}" class="btn btn-warning btn-sm"
                           data-toggle="ajax-modal" data-target="#entity-modal"
                           data-url="{{ route('entities.inventories.create', ['entity' => $entity]) }}"
                        >
                            <i class="fa fa-plus"></i>
                            {{ __('entities/inventories.actions.add') }}
                        </a>
                    @endif
                    @includeWhen($inventory->count() > 0, 'entities.pages.inventory._inventory')
                </div>
            </div>
        </div>
    </div>

@endsection
