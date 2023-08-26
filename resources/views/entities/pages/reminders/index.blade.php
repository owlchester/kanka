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
               class="btn2 btn-sm btn-accent" data-toggle="dialog" data-target="primary-dialog"
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

        <div class="entity-main-block flex flex-col gap-5">
            <x-tutorial code="events" doc="https://docs.kanka.io/en/latest/features/reminders.html">
                <p>{{ __('entities/events.helpers.no_events_v2') }}</p>
            </x-tutorial>

            @if ($rows->count() > 0)
                <div id="datagrid-parent" class="table-responsive">
                    @include('layouts.datagrid._table')
                </div>
            @endif
        </div>
    </div>

@endsection

@section('modals')
    @parent
    <x-dialog id="edit-dialog" :loading="true" />
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
