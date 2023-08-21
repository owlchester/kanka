@php
    $plural = \App\Facades\Module::plural(config('entities.ids.event'), __('entities.events'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end">
        @if (request()->has('parent_id'))
            <a href="{{ route('events.events', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('events.events', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.direct') }}</span>
                ({{ $model->events()->count() }})
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

        @include('entities.components.menu_v2', ['active' => 'events'])

        <div class="entity-main-block">
            @include('events.panels.events')
        </div>
    </div>
@endsection

