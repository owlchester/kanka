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
@inject('campaignService', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons inline-block pull-right ml-auto">
            <a href="{{ $model->getLink('edit') }}" class="btn2 btn-accent btn-sm">
                {{ __('entities/profile.actions.edit_profile') }}
            </a>
        </div>
    @endcan
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
                __('crud.tabs.profile')
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'profile',
            'model' => $entity->child,
        ])

        <div class="entity-main-block">
            @includeIf('entities.pages.profile._' . $model->getEntityType())
        </div>
    </div>
@endsection
