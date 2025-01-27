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
            <a href="{{ route('entities.children', [$campaign, $entity, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.all') }}</span>
                ({{ $entity->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('entities.children', [$campaign, $entity, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $entity->children()->count() }})
            </a>
        @endif
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
