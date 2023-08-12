@extends('layouts.app', [
    'title' => $model->name . ' - ' . \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    <div class="header-buttons inline-block flex gap-2 items-center justify-end">
        @if (request()->has('parent_id'))
            <a href="{{ route('races.races', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('races.races', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.direct') }}</span>
                ({{ $model->races()->count() }})
            </a>
        @endif
    </div>
@endsection

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races'));
@endphp
@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('races'), 'label' => $plural],
                $plural
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'races'])

        <div class="entity-main-block">
            @include('races.panels.races')
        </div>
    </div>
@endsection
