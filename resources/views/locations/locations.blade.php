@extends('layouts.app', [
    'title' => $entity->name . ' ' . \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
])

@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @if ($mode === \App\Enums\Descendants::Direct)
            <a href="{{ route('locations.locations', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('locations.locations', [$campaign, $model, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->children()->count() }})
            </a>
        @endif
        @include('entities.headers.actions', ['edit' => false])
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
    ])
@endsection
