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

@include('entities.components.og')

@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
            <a href="{{ $model->getLink('edit') }}" class="btn2 btn-sm">
                {{ __('entities/profile.actions.edit_profile') }}
            </a>
        </div>
    @endcan
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'profile',
        'breadcrumb' => __('crud.tabs.profile'),
        'view' => 'entities.pages.profile._' . $model->getEntityType(),
        'entity' => $entity,
        'model' => $entity->child,
    ])
@endsection
