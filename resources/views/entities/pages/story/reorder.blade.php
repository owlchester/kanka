<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\EntityNote[]|\Illuminate\Support\Collection $notes
 * @var \App\Models\EntityNote $first
 */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.reorder.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-story-reorder'
])


@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                Breadcrumb::entity($entity)->list(),
                __('entities/story.reorder.panel_title')
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'story',
            'model' => $entity->child,
        ])

        <div class="entity-main-block">
            @include('entities.pages.story._reorder')
        </div>
    </div>
@endsection
