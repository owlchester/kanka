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
@inject('campaignService', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('events', $entity->child)
        <div class="header-buttons inline-block pull-right ml-auto">
            <a href="{{ route('entities.entity_events.create', [$entity, 'next' => 'entity.events']) }}" id="entity-calendar-modal-add"
               class="btn btn-sm btn-warning pull-right" data-toggle="ajax-modal" data-target="#entity-modal"
               data-url="{{ route('entities.entity_events.create', [$entity, 'next' => 'entity.events']) }}">
                <x-icon class="plus"></x-icon> {{ __('entities/events.show.actions.add') }}
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
                __('crud.tabs.reminders')
            ]
        ])

        @include($entity->pluralType() . '._menu', [
            'active' => 'reminders',
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">
            <x-tutorial code="events" doc="https://docs.kanka.io/en/latest/features/reminders.html">
                <p>{{ __('entities/events.helpers.no_events_v2') }}</p>
            </x-tutorial>
            <div class="mb-5"></div>

            @if ($reminders->count() > 0)
                <div class="box box-solid box-entity-reminders">
                    <div class="box-body no-padding">
                        @include('entities.pages.reminders._table')
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
