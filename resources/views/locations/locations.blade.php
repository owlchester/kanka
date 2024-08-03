@extends('layouts.app', [
    'title' => $model->name . ' ' . \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @if (request()->has('parent_id'))
            <a href="{{ route('locations.locations', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('locations.locations', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->children()->count() }})
            </a>
        @endif
    </div>
@endsection

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations'));
@endphp
@section('content')
    @include('entities.pages.subpage', [
        'active' => 'locations',
        'breadcrumb' => $plural,
        'view' => 'locations.panels.locations',
        'entity' => $model->entity,
    ])
@endsection
