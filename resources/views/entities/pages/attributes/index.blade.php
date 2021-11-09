<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-attributes'
])
@inject('campaign', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('attribute', [$entity->child, 'add'])
        <div class="header-buttons">
            <a class="btn btn-sm btn-default" href="{{ route('entities.attributes.template', $entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.attributes.template', $entity) }}">
                <i class="fa fa-copy"></i> {{ __('entities/attributes.actions.apply_template') }}
            </a>

            <a href="{{ route('entities.attributes.edit', ['entity' => $entity]) }}" class="btn btn-sm btn-warning">
                <i class="fa fa-list"></i> {{ __('entities/attributes.actions.manage') }}
            </a>
        </div>
    @endcan
@endsection


@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header_grid', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
                __('crud.tabs.attributes')
            ]
        ])

        @include($entity->pluralType() . '._menu', [
            'active' => 'attributes',
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">
            <div class="box box-solid box-entity-attributes">
                <div class="box-body">
            @include('entities.pages.attributes.render')
                </div>
            </div>
        </div>
    </div>
@endsection
