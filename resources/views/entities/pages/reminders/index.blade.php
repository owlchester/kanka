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

@include('entities.components.og')

@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        @can('events', $entity->child)
            <a href="https://docs.kanka.io/en/latest/features/reminders.html" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question" /> {{ __('crud.actions.help') }}
            </a>
            <a href="{{ route('entities.entity_events.create', [$campaign, $entity, 'next' => 'entity.events']) }}" id="entity-calendar-modal-add"
               class="btn2 btn-sm" data-toggle="dialog" data-target="primary-dialog"
               data-url="{{ route('entities.entity_events.create', [$campaign, $entity, 'next' => 'entity.events']) }}">
                <x-icon class="plus" /> {{ __('entities/events.show.actions.add') }}
            </a>
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'reminders',
        'breadcrumb' => __('crud.tabs.reminders'),
        'view' => 'entities.pages.reminders._list',
        'entity' => $entity,
        'model' => $entity->child,
    ])
@endsection

