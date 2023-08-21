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
    <div class="header-buttons inline-block pull-right ml-auto">
        <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
        </a>
        @if (request()->has('tag_id'))
            <a href="{{ route('tags.tags', [$campaign, $model, '#tag-tags']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('tags.tags', [$campaign, $model, 'tag_id' => $model->id, '#tag-tags']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.direct') }}</span>
                ({{ $model->tags()->count() }})
            </a>
        @endif
    </div>
@endsection

@section('content')
    @include('partials.errors')
    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                Breadcrumb::entity($model->entity)->list(),
                $plural
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'tags'])

        <div class="entity-main-block">
            @include('tags.panels.tags')
        </div>
    </div>
@endsection
