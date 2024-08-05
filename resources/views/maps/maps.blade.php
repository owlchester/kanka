@php
    $plural = \App\Facades\Module::plural(config('entities.ids.map'), __('entities.maps'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' ' . $plural,
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @if (request()->has('map_id'))
            <a href="{{ route('maps.maps', [$campaign, $model, '#map-maps']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants->count() }})
            </a>
        @else
            <a href="{{ route('maps.maps', [$campaign, $model, 'map_id' => $model->id, '#map-maps']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->children->count() }})
            </a>
        @endif
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'maps',
        'breadcrumb' => $plural,
        'view' => 'maps.panels.maps',
        'entity' => $model->entity,
    ])
@endsection
