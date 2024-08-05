@php
    $plural = \App\Facades\Module::plural(config('entities.ids.tag'), __('entities.tags'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    <div class="header-buttons inline-block ml-auto">
        <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
        </a>
        @if (request()->has('tag_id'))
            <a href="{{ route('tags.tags', [$campaign, $model, '#tag-tags']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('tags.tags', [$campaign, $model, 'tag_id' => $model->id, '#tag-tags']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->children()->count() }})
            </a>
        @endif
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'tags',
        'breadcrumb' => $plural,
        'view' => 'tags.panels.tags',
        'entity' => $model->entity,
    ])
@endsection
