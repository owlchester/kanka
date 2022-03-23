<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/profile.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
    'bodyClass' => 'entity-profile'
])
@inject('campaign', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons">
            <a href="{{ $model->getLink('edit') }}" class="btn btn-warning">
                {{ __('entities/profile.actions.edit_profile') }}
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
                __('crud.tabs.profile')
            ]
        ])

        @include($entity->pluralType() . '._menu', [
            'active' => 'profile',
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">
            @includeIf('entities.pages.profile._' . $model->getEntityType())
        </div>
    </div>
@endsection
