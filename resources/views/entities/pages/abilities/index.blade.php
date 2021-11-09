<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Ability $ability */?>
@extends('layouts.app', [
    'title' => __('entities/abilities.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-abilities'
])
@inject('campaign', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('update', $entity->child)
        <div class="header-buttons">
            <a href="{{ route('entities.entity_abilities.reset', $entity) }}" class="btn btn-sm btn-default">
                <i class="fa fa-redo"></i> <span class="hidden-xs hidden-sm">{{ __('entities/abilities.actions.reset') }}</span>
                <span class="visible-xs visible-sm">{{ __('crud.actions.reset') }}</span>
            </a>
            @if ($entity->typeId() == config('entities.ids.character'))
                <a href="{{ route('entities.entity_abilities.import', [$entity, 'from' => 'race']) }}" class="btn btn-sm btn-default">
                    <i class="ra ra-wyvern"></i>
                    <span class="hidden-sm hidden-xs">{{ __('entities/abilities.actions.import_from_race') }}</span>
                    <span class="visible-xs visible-sm">{{ __('entities/abilities.actions.import_from_race_mobile') }}</span>
                </a>
            @endif
            <a href="{{ route('entities.entity_abilities.create', $entity) }}" class="btn btn-sm btn-warning"
               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_abilities.create', $entity) }}">
                <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('entities/abilities.actions.add') }}</span>
                <span class="visible-xs visible-sm">{{ __('crud.add') }}</span>
            </a>
        </div>
    @endcan
@endsection


@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header_grid', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
                __('crud.tabs.abilities')
            ]
        ])

        @include($entity->pluralType() . '._menu', [
            'active' => 'abilities',
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">
            @include('entities.pages.abilities._abilities')
        </div>
    </div>

@endsection


@section('styles')
    @parent
    <link href="{{ mix('css/abilities.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/abilities.js') }}" defer></script>
@endsection
