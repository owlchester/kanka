<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/profile.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'bodyClass' => 'entity-profile'
])

@include('entities.components.og')

@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        @can('update', $entity)
            <a href="{{ $entity->url('edit') }}" class="btn2 btn-sm">
                {{ __('entities/profile.actions.edit_profile') }}
            </a>
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'profile',
        'view' => 'entities.pages.profile._' . $entity->entityType->code,
        'entity' => $entity,
    ])
@endsection
