<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Ability $ability */?>
@extends('layouts.app', [
    'title' => __('entities/abilities.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-abilities'
])
@inject('campaignService', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('update', $entity->child)
        <div class="header-buttons inline-block pull-right ml-auto">
            <a href="{{ route('entities.entity_abilities.reorder', $entity) }}" class="btn2 btn-sm">
                <x-icon class="fa-solid fa-sort"></x-icon>
                <span class="hidden-xs hidden-sm">{{ __('entities/abilities.show.reorder') }}</span>
                <span class="visible-xs visible-sm">{{ __('sidebar.campaign_switcher.reorder') }}</span>
            </a>
            <a href="{{ route('entities.entity_abilities.reset', $entity) }}" class="btn2 btn-sm">
                <x-icon class="fa-solid fa-redo"></x-icon>
                <span class="hidden-xs hidden-sm">{{ __('entities/abilities.actions.reset') }}</span>
                <span class="visible-xs visible-sm">{{ __('crud.actions.reset') }}</span>
            </a>
            @if ($entity->isCharacter())
                <a href="{{ route('entities.entity_abilities.import', [$entity, 'from' => 'race']) }}" class="btn2 btn-sm">
                    <x-icon class="ra ra-wyvern"></x-icon>
                    <span class="hidden-sm hidden-xs">{{ __('entities/abilities.actions.import_from_race') }}</span>
                    <span class="visible-xs visible-sm">{{ __('entities/abilities.actions.import_from_race_mobile') }}</span>
                </a>
            @endif
            <a href="{{ route('entities.entity_abilities.create', $entity) }}" class="btn2 btn-sm btn-accent"
               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_abilities.create', $entity) }}">
                <x-icon class="plus"></x-icon>
                <span class="hidden-sm hidden-xs">{{ __('entities/abilities.actions.add') }}</span>
                <span class="visible-xs visible-sm">{{ __('crud.add') }}</span>
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


@section('styles')
    @parent
    @vite('resources/sass/abilities.scss')
@endsection

@section('scripts')
    @parent
    @vite('resources/js/abilities.js')
@endsection
