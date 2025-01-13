<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Post[]|\Illuminate\Support\Collection $notes
 * @var \App\Models\Post $first
 */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.reorder.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->entityType->isSpecial() ? $entity : $entity->child,
    'bodyClass' => 'entity-story-reorder'
])


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'story',
        'breadcrumb' => __('entities/story.reorder.panel_title'),
        'view' => 'entities.pages.story._reorder',
        'entity' => $entity,
    ])
@endsection
