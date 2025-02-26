@php
    $plural = \App\Facades\Module::plural(config('entities.ids.ability'), __('entities.abilities'));
@endphp
@extends('layouts.app', [
    'title' => $entity->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        @if ($mode === \App\Enums\Descendants::Direct)
            <a href="{{ route('abilities.abilities', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->has('entity')->count() }})
            </a>
        @else
            <a href="{{ route('abilities.abilities', [$campaign, $model, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->children()->has('entity')->count() }})
            </a>
        @endif
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')

    @include('entities.pages.subpage', [
        'active' => 'abilities',
        'breadcrumb' => $plural,
        'view' => 'abilities.panels.abilities',
    ])
@endsection
