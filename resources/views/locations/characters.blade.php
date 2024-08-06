@extends('layouts.app', [
    'title' => $model->name . ' ' . \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question" />
            <span class="hidden xl:inline">{{ __('crud.actions.help') }}</span>
        </a>
        @if (request()->has('parent_id'))
            <a href="{{ route('locations.characters', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->allCharacters()->count() }})
            </a>
        @else
            <a href="{{ route('locations.characters', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->characters()->count() }})
            </a>
        @endif
    </div>
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'characters',
        'breadcrumb' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
        'view' => 'locations.panels.characters',
        'entity' => $model->entity,
    ])
@endsection
