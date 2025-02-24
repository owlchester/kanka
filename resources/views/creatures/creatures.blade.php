@php
    $plural = \App\Facades\Module::plural(config('entities.ids.creature'), __('entities.creatures'));
@endphp
@extends('layouts.app', [
    'title' => $entity->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @if ($mode === \App\Enums\Descendants::Direct)
            <a href="{{ route('creatures.creatures', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->has('entity')->count() }})
            </a>
        @else
            <a href="{{ route('creatures.creatures', [$campaign, $model, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
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
        'active' => 'creatures',
        'breadcrumb' => $plural,
        'view' => 'creatures.panels.creatures',
    ])
@endsection
