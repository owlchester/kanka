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
    'bodyClass' => 'entity-story-reorder'
])


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'story',
        'view' => 'entities.pages.story._reorder',
        'entity' => $entity,
    ])
@endsection
