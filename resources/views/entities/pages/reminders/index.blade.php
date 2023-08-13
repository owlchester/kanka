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


@section('entity-header-actions')
    @can('events', $entity->child)
        <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
            <a href="https://docs.kanka.io/en/latest/features/reminders.html" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
            </a>
            <a href="{{ route('entities.entity_events.create', [$campaign, $entity, 'next' => 'entity.events']) }}" id="entity-calendar-modal-add"
               class="btn2 btn-sm btn-accent" data-toggle="ajax-modal" data-target="#entity-modal"
               data-url="{{ route('entities.entity_events.create', [$campaign, $entity, 'next' => 'entity.events']) }}">
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
                Breadcrumb::entity($entity)->list(),
                __('crud.tabs.reminders')
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'reminders',
            'model' => $entity->child,
        ])

        <div class="entity-main-block">
            <x-tutorial code="events" doc="https://docs.kanka.io/en/latest/features/reminders.html">
                <p>{{ __('entities/events.helpers.no_events_v2') }}</p>
            </x-tutorial>
            <div class="mb-5"></div>

            @if ($reminders->count() > 0)
                <x-box css="box-entity-reminders" :padding="false">
                    <div class="table-responsive">
                    @include('entities.pages.reminders._table')
                    </div>
                </x-box>

                @if ($reminders->hasPages())
                    <div class="text-right">
                        {{ $reminders->fragment('tab_calendars')->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

@endsection
