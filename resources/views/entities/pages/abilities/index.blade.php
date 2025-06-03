<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Ability $ability */?>
@extends('layouts.app', [
    'title' => __('entities/abilities.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'bodyClass' => 'entity-abilities'
])

@include('entities.components.og')

@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        @can('update', $entity)
            <x-learn-more url="entities/abilities.html#entity-abilities" />
            @include('entities.pages.abilities._buttons')
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'abilities',
        'breadcrumb' => __('entities.abilities'),
        'view' => 'entities.pages.abilities.render',
        'entity' => $entity,
    ])
@endsection

@section('modals')
    @parent
    <x-dialog id="abilities-dialog" :loading="true" />
@endsection
