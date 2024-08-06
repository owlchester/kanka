<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Ability $ability */?>
@extends('layouts.app', [
    'title' => __('entities/abilities.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-abilities'
])

@include('entities.components.og')

@section('entity-header-actions')
    @can('update', $entity->child)
        <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
            <a href="https://docs.kanka.io/en/latest/entities/abilities.html#entity-abilities" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question" /> {{ __('crud.actions.help') }}
            </a>
            @include('entities.pages.abilities._buttons')
        </div>
    @endcan
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'abilities',
        'breadcrumb' => __('entities.abilities'),
        'view' => 'entities.pages.abilities.render',
        'entity' => $entity,
        'model' => $entity->child,
    ])
@endsection

@section('modals')
    @parent
    <x-dialog id="abilities-dialog" :loading="true" />
@endsection
