@php
    $plural = \App\Facades\Module::plural(config('entities.ids.tag'), __('entities.tags'));
@endphp
@extends('layouts.app', [
    'title' => $entity->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('entity-header-actions')
    <div class="header-buttons inline-block ml-auto">
        <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question" /> {{ __('crud.actions.help') }}
        </a>
        @if ($mode === \App\Enums\Descendants::Direct)
            <a href="{{ route('tags.tags', [$campaign, $entity->child, 'm' => \App\Enums\Descendants::All, '#tag-tags']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.all') }}</span>
                ({{ $entity->child->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('tags.tags', [$campaign, $entity->child, 'm' => \App\Enums\Descendants::Direct, '#tag-tags']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $entity->child->children()->count() }})
            </a>
        @endif
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'tags',
        'breadcrumb' => $plural,
        'view' => 'tags.panels.tags',
    ])
@endsection
