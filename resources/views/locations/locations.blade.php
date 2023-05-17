@extends('layouts.app', [
    'title' => $model->name . ' ' . \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    <div class="header-buttons inline-block pull-right ml-auto">
        @if (request()->has('parent_id'))
            <a href="{{ route('locations.locations', [$model]) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter" aria-hidden="true"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('locations.locations', [$model, 'parent_id' => $model->id]) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter" aria-hidden="true"></i> {{ __('crud.filters.direct') }} ({{ $model->locations()->count() }})
            </a>
        @endif
    </div>
@endsection

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations'));
@endphp
@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('locations'), 'label' => $plural],
                $plural
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'locations'])

        <div class="entity-main-block">
            @include('locations.panels.locations')
        </div>
    </div>
@endsection
