<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityMention $mention */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/mentions.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'bodyClass' => 'entity-mentions'
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
        'active' => 'mentions',
        'view' => 'entities.pages.mentions.render',
        'entity' => $entity,
    ])
@endsection


@section('modals')
    <x-dialog id="dialog-help" :title="__('crud.tabs.mentions')">
        <p class="">
            {{ __('entities/mentions.helper') }}
        </p>
    </x-dialog>
@endsection
