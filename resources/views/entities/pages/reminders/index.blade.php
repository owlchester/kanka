<?php
/** @var \App\Models\Entity $entity */
/** @var \App\Models\EntityEvent $relation */
?>
@extends('layouts.app', [
    'title' => __('entities/events.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-reminders'
])
@inject('campaign', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('events', $entity->child)
        <div class="header-buttons">
            <a href="{{ route('entities.entity_events.create', [$entity, 'next' => 'entity.events']) }}" id="entity-calendar-modal-add"
               class="btn btn-sm btn-warning pull-right" data-toggle="ajax-modal" data-target="#entity-modal"
               data-url="{{ route('entities.entity_events.create', [$entity, 'next' => 'entity.events']) }}">
                <i class="fa fa-plus"></i> {{ __('entities/events.show.actions.add') }}
            </a>
        </div>
    @endcan

@endsection


@section('content')
    @include('partials.errors')
    @include('partials.ads.top')

    <div class="entity-grid">
        @include('entities.components.header_grid', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
                __('crud.tabs.reminders')
            ]
        ])

        @include($entity->pluralType() . '._menu', [
            'active' => 'reminders',
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">
            <div class="box box-solid box-entity-reminders">
                <div class="box-body">
                    @include('entities.pages.reminders._table')
                </div>
            </div>
        </div>
    </div>

@endsection
