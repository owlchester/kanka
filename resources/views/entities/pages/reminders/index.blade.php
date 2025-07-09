<?php
/** @var \App\Models\Entity $entity */
/** @var \App\Models\EntityEvent $relation */
?>
@extends('layouts.app', [
    'title' => __('entities/events.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'bodyClass' => 'entity-reminders'
])

@include('entities.components.og')

@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        <x-learn-more url="features/reminders.html" />
        @can('reminders', $entity)
            <a href="{{ route('entities.reminders.create', [$campaign, $entity, 'next' => 'entity.reminders']) }}" id="entity-calendar-modal-add"
               class="btn2 btn-sm" data-toggle="dialog" data-target="primary-dialog"
               data-url="{{ route('entities.reminders.create', [$campaign, $entity, 'next' => 'entity.reminders']) }}">
                <x-icon class="plus" /> {{ __('entities/events.show.actions.add') }}
            </a>
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'reminders',
        'view' => 'entities.pages.reminders._list',
        'entity' => $entity,
    ])
@endsection

