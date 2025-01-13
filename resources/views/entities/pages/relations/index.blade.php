<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $entity->entityType->isSpecial() ? $entity : $entity->child,
    'bodyClass' => 'entity-relations'
])


@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        <button class="btn2 btn-ghost btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question" /> {{ __('crud.actions.help') }}
        </button>
        @if ($mode == 'map' || (empty($mode) && $campaign->boosted()))
            <a href="{{ route('entities.relations.index', [$campaign, $entity, 'mode' => 'table']) }}" class="btn2 btn-sm" data-toggle="tooltip" data-title="{{ __('entities/relations.actions.mode-table') }}">
                <x-icon class="fa-solid fa-list-ul" />
            </a>
        @else
            <a href="{{ route('entities.relations.index', [$campaign, $entity, 'mode' => 'map']) }}" class="btn2 btn-sm" data-toggle="tooltip" data-title="{{ __('entities/relations.actions.mode-map') }}">
                <x-icon class="map" />
            </a>
        @endif
        @include('entities.pages.relations._buttons')
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection



@section('content')

    @include('entities.pages.subpage', [
        'active' => 'relations',
        'breadcrumb' => __('crud.tabs.connections'),
        'view' => 'entities.pages.relations.render',
        'entity' => $entity,
    ])
@endsection


@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'help-modal',
        'title' => __('crud.actions.help'),
        'textes' => [
            __('entities/relations.helpers.popup')
        ]
    ])
@endsection
