<?php
/** @var \App\Models\Entity $entity */
/** @var \App\Models\EntityEvent $relation */
?>
@extends('layouts.app', [
    'title' => __('entities/events.show.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.reminders')
    ],
    'mainTitle' => false,
    'miscModel' => $entity->child,
])
@inject('campaign', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('events', $entity->child)
        <div class="header-buttons">
            <a href="{{ route('entities.entity_events.create', [$entity, 'next' => 'entity.events']) }}" id="entity-calendar-modal-add"
               class="btn btn-sm btn-primary pull-right" data-toggle="ajax-modal" data-target="#entity-modal"
               data-url="{{ route('entities.entity_events.create', [$entity, 'next' => 'entity.events']) }}">
                <i class="fa fa-plus"></i> {{ __('entities/events.show.actions.add') }}
            </a>
        </div>
    @endcan

@endsection

@include('entities.components.header', ['model' => $entity->child, 'entity' => $entity])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include($entity->pluralType() . '._menu', ['active' => 'reminders', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-10">
            <div class="box box-solid">

                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('crud.tabs.reminders') }}
                    </h3>
                </div>
                <div class="box-body">
                    @include('entities.pages.reminders._table')
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    @parent
    <script src="/vendor/spectrum/spectrum.js" defer></script>
@endsection


@section('styles')
    @parent
    <link href="/vendor/spectrum/spectrum.css" rel="stylesheet">
@endsection
