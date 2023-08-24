@extends('layouts.app', [
    'title' => $model->name . ' - ' . \App\Facades\Module::plural(config('entities.ids.family'), __('entities.families')),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end">
        @if (request()->has('parent_id'))
            <a href="{{ route('families.families', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.all') }}</span>({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('families.families', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.direct') }}</span>({{ $model->families()->count() }})
            </a>
        @endif
    </div>
@endsection

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.family'), __('entities.families'));
@endphp
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

        @include('entities.components.menu_v2', ['active' => 'families'])

        <div class="entity-main-block">
            @include('families.panels.families')
        </div>
    </div>
@endsection
