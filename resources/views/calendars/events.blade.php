@extends('layouts.app', [
    'title' => $model->name . ' - ' . __('crud.tabs.reminders'),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end">
        @if (!request()->has('before_id'))
            <a href="{{ route('calendars.events', [$campaign, $model, 'before_id' => 1]) }}" class="btn2 btn-sm">
                {{ __('calendars.events.filters.show_before') }}
            </a>
        @endif
        @if (!request()->has('after_id'))
            <a href="{{ route('calendars.events', [$campaign, $model, 'after_id' => 1]) }}" class="btn2 btn-sm">
                {{ __('calendars.events.filters.show_after') }}
            </a>
        @endif
        @if (request()->has('after_id') || request()->has('before_id'))
            <a href="{{ route('calendars.events', [$campaign, $model]) }}" class="btn2 btn-sm">
                {{ __('calendars.events.filters.show_all') }}
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
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'events'])

        <div class="entity-main-block">
            @include('calendars.panels.events')
        </div>
    </div>
@endsection
