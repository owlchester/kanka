@extends('layouts.app', [
    'title' => $entity->name . ' - ' . $entity->entityType->plural(),
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @if ($mode === \App\Enums\Descendants::Direct)
            <x-toggles.filter-button
                route="{{ route('events.events', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}"
                :count="$model->descendants()->has('entity')->count()"
                all
            />
        @else
            <x-toggles.filter-button
                route="{{ route('events.events', [$campaign, $model, 'm' => \App\Enums\Descendants::Direct]) }}"
                :count="$model->children()->has('entity')->count()"
            />
        @endif
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'events',
        'view' => 'events.panels.events',
    ])
@endsection

