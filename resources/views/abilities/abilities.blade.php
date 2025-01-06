@php
    $plural = \App\Facades\Module::plural(config('entities.ids.ability'), __('entities.abilities'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    <div class="header-buttons inline-block ml-auto">
        @if ($mode === \App\Enums\Descendants::Direct)
            <a href="{{ route('abilities.abilities', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('abilities.abilities', [$campaign, $model, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->children()->count() }})
            </a>
        @endif
    </div>
@endsection

@section('content')

    @include('entities.pages.subpage', [
        'active' => 'abilities',
        'breadcrumb' => $plural,
        'view' => 'abilities.panels.abilities',
        'entity' => $model->entity,
    ])
@endsection
