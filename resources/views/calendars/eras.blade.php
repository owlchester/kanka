@extends('layouts.app', [
    'title' => $entity->name . ' - ' . __('calendars/eras.title'),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
])

@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @can('update', $entity)
            <a href="{{ route('calendars.calendar_eras.create', [$campaign, 'calendar' => $model]) }}" class="btn2 btn-sm">
                <x-icon class="plus" />
                <span class="hidden lg:inline">{{ __('calendars/eras.actions.add') }}</span>
            </a>
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'eras',
        'view' => 'calendars.panels.eras',
    ])
@endsection
