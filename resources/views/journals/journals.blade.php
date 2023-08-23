@php
    $plural = \App\Facades\Module::plural(config('entities.ids.journal'), __('entities.journals'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end">
        @if (request()->has('parent_id'))
            <a href="{{ route('journals.journals', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->allJournals()->count() }})
            </a>
        @else
            <a href="{{ route('journals.journals', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->journals()->count() }})
            </a>
        @endif
    </div>
@endsection

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

        @include('entities.components.menu_v2', ['active' => 'journals'])

        <div class="entity-main-block">
            @include('journals.panels.journals')
        </div>
    </div>
@endsection

