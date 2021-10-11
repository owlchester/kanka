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
                <i class="fa fa-plus"></i> <span class="visible-lg-inline">{{ __('entities/inventories.actions.add') }}</span>
            </a>
        </div>
    @endcan
@endsection


@include('entities.components.header', [
    'model' => $entity->child,
    'entity' => $entity,
    'breadcrumb' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
        __('crud.tabs.inventory')
    ]
])
@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include($entity->pluralType() . '._menu', ['active' => 'inventory', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-10 entity-main-block">
            <div class="box box-solid box-entity-inventory">
                <div class="box-body">
                    @if ($inventory->count() === 0)
                        <p class="help-block">{{ __('entities/inventories.show.helper') }}</p>

                    @endif
                    @includeWhen($inventory->count() > 0, 'entities.pages.inventory._inventory')
                </div>
            </div>
        </div>
    </div>
@endsection
