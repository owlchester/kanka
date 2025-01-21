<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityMention $mention */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/children.title') . ' - ' . $entity->name,
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'bodyClass' => 'entity-children'
])


@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
                data-target="dialog-help">
            <x-icon class="question" />
            {{ __('crud.actions.help') }}
        </button>
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'children',
        'breadcrumb' => __('entities/children.title'),
        'view' => 'entities.pages.children.children',
        'entity' => $entity,
    ])
@endsection
