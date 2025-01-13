@extends('layouts.app', [
    'title' => $entity->name . ' ' . \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question" />
            <span class="hidden lg:inline">{{ __('crud.actions.help') }}</span>
        </a>
        @if ($mode === \App\Enums\Descendants::Direct)
            <a href="{{ route('locations.characters', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->allCharacters()->count() }})
            </a>
        @else
            <a href="{{ route('locations.characters', [$campaign, $model, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->characters()->count() }})
            </a>
        @endif
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'characters',
        'breadcrumb' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
        'view' => 'locations.panels.characters',
    ])
@endsection
