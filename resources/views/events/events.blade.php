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
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @if (request()->has('parent_id'))
            <a href="{{ route('events.events', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('events.events', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->children()->count() }})
            </a>
        @endif
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'events',
        'breadcrumb' => $plural,
        'view' => 'events.panels.events',
        'entity' => $model->entity,
    ])
@endsection

