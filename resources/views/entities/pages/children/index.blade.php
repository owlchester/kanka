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
        @if ($mode === \App\Enums\Descendants::Direct)
            <x-toggles.filter-button
                route="{{ route('entities.children', [$campaign, $entity, 'm' => \App\Enums\Descendants::All]) }}"
                :count="$entity->descendants()->count()"
                all
            />
        @else
            <x-toggles.filter-button
                route="{{ route('entities.children', [$campaign, $entity, 'm' => \App\Enums\Descendants::Direct]) }}"
                :count="$entity->children()->count()"
            />
        @endif
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'children',
        'view' => 'entities.pages.children.children',
        'entity' => $entity,
    ])
@endsection
