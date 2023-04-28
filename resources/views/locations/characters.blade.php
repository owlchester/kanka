@extends('layouts.app', [
    'title' => $model->name . ' ' . \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    <div class="header-buttons inline-block pull-right ml-auto">
        <a href="#" class="btn btn-default btn-sm" data-toggle="dialog" data-target="help-modal">
            <i class="fa-solid fa-question-circle" aria-hidden="true"></i> {{ __('crud.actions.help') }}
        </a>
        @if (request()->has('parent_id'))
            <a href="{{ route('locations.characters', $model) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allCharacters()->count() }})
            </a>
        @else
            <a href="{{ route('locations.characters', [$model, 'parent_id' => $model->id]) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->characters()->count() }})
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
                ['url' => Breadcrumb::index('locations'), 'label' => \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations'))],
                \App\Facades\Module::plural(config('entities.ids.character'), __('entities.locations'))
            ]
        ])

        @include('locations._menu', ['active' => 'characters'])

        <div class="entity-main-block">
            @include('locations.panels.characters')
        </div>
    </div>
@endsection
