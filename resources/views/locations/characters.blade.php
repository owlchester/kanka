@extends('layouts.app', [
    'title' => $model->name . ' ' . \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end">
        <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
        </a>
        @if (request()->has('parent_id'))
            <a href="{{ route('locations.characters', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.all') }}</span>
                ({{ $model->allCharacters()->count() }})
            </a>
        @else
            <a href="{{ route('locations.characters', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.direct') }}</span>
                ({{ $model->characters()->count() }})
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
                \App\Facades\Module::plural(config('entities.ids.character'), __('entities.locations'))
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'characters'])

        <div class="entity-main-block">
            @include('locations.panels.characters')
        </div>
    </div>
@endsection
