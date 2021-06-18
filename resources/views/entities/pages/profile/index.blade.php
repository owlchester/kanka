<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/profile.show.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.profile')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
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
    <div class="row">
        <div class="col-md-2">
            @include($entity->pluralType() . '._menu', [
                'active' => 'profile',
                'model' => $model,
                'name' => $entity->pluralType()
            ])
        </div>
        <div class="col-md-10">
            @includeIf('entities.pages.profile._' . $model->getEntityType())
        </div>
    </div>
@endsection
