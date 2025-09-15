@extends('layouts.app', [
    'title' => $entity->name . ' - ' . $entity->entityType->plural(),
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('entity-header-actions')
    <div class="header-buttons inline-block ml-auto">
        <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question" /> {{ __('crud.actions.help') }}
        </a>
        @if ($mode === \App\Enums\Descendants::Direct)
            <x-toggles.filter-button
                route="{{ route('tags.tags', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}"
                :count="$entity->child->descendants()->has('entity')->count()"
                all
            />
        @else
            <x-toggles.filter-button
                route="{{ route('tags.tags', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}"
                :count="$entity->child->children()->has('entity')->count()"
            />
        @endif
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'tags',
        'view' => 'tags.panels.tags',
    ])
@endsection
