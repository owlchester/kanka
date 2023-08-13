<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Ability $ability */?>
@extends('layouts.app', [
    'title' => __('entities/abilities.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-abilities'
])


@section('entity-header-actions')
    @can('update', $entity->child)
        <div class="header-buttons inline-block flex flex-wrap gap-2 items-center justify-end">
            <a href="https://docs.kanka.io/en/latest/entities/abilities.html#entity-abilities" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
            </a>
            @include('entities.pages.abilities._buttons')
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
                Breadcrumb::entity($entity)->list(),
                \App\Facades\Module::plural(config('entities.ids.ability'), __('entities.abilities'))
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'abilities',
            'model' => $entity->child,
        ])

        <div class="entity-main-block">
            @include('entities.pages.abilities._abilities')
        </div>
    </div>

@endsection
