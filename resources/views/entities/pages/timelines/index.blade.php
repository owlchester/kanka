<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\TimelineElement $element
 */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/timelines.show.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('entities.timelines')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-timelines'
])

@section('content')
    @include('partials.errors')


    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                Breadcrumb::entity($entity)->list(),
                __('entities.timelines')
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'timelines',
            'model' => $entity->child,
        ])

        <div class="entity-main-block">
            @include('entities.pages.timelines._timelines')
        </div>
    </div>
@endsection

