<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.attributes')
    ],
    'mainTitle' => false,
    'miscModel' => $entity->child,
])
@inject('campaign', 'App\Services\CampaignService')
@inject('attributeService', 'App\Services\AttributeService')


@section('entity-header-actions')
    @can('attribute', [$entity->child, 'add'])
        <div class="header-buttons">
            <a class="btn btn-primary" href="{{ route('entities.attributes.template', $entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.attributes.template', $entity) }}">
                <i class="fa fa-copy"></i> <span class="hidden-xs hidden-sm">{{ __('entities/attributes.actions.apply_template') }}</span>
            </a>

            <a href="{{ route('entities.attributes.edit', ['entity' => $entity]) }}" class="btn btn-primary">
                <i class="fa fa-list"></i> <span class="hidden-xs hidden-sm">{{ __('entities/attributes.actions.manage') }}</span>
            </a>
        </div>
    @endcan
@endsection

@include('entities.components.header', ['model' => $entity->child, 'entity' => $entity])


@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include($entity->pluralType() . '._menu', ['active' => 'attributes', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-10">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('crud.tabs.attributes') }}
                    </h3>
                </div>
                <div class="box-body">
                    @include('entities.pages.attributes.render')
                </div>
            </div>
        </div>
    </div>
@endsection
