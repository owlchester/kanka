<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/profile.show.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.profile')
    ],
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

@include('entities.components.header', ['model' => $model, 'entity' => $entity])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include($entity->pluralType() . '._menu', [
                'active' => 'profile',
                'model' => $model,
                'name' => $entity->pluralType()
            ])
        </div>
        <div class="col-md-10 entity-main-block">
            @includeIf('entities.pages.profile._' . $model->getEntityType())
        </div>
    </div>
@endsection
