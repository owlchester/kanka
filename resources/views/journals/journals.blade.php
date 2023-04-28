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
    <div class="header-buttons inline-block pull-right ml-auto">
        @if (request()->has('parent_id'))
            <a href="{{ route('journals.journals', [$model]) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter" aria-hidden="true"></i> {{ __('crud.filters.all') }} ({{ $model->allJournals()->count() }})
            </a>
        @else
            <a href="{{ route('journals.journals', [$model, 'parent_id' => $model->id]) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter" aria-hidden="true"></i> {{ __('crud.filters.direct') }} ({{ $model->journals()->count() }})
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
                ['url' => Breadcrumb::index('journals'), 'label' => $plural],
                $plural
            ]
        ])

        @include('journals._menu', ['active' => 'journals'])

        <div class="entity-main-block">
            @include('journals.panels.journals')
        </div>
    </div>
@endsection

