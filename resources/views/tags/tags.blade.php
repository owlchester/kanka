@php
    $plural = \App\Facades\Module::plural(config('entities.ids.tag'), __('entities.tags'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    <div class="header-buttons inline-block pull-right ml-auto">
        <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
        </a>
        @if (request()->has('tag_id'))
            <a href="{{ route('tags.tags', [$model, '#tag-tags']) }}" class="btn2 btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('tags.tags', [$model, 'tag_id' => $model->id, '#tag-tags']) }}" class="btn2 btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->tags()->count() }})
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
                ['url' => Breadcrumb::index('tags'), 'label' => $plural],
                $plural
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'tags'])

        <div class="entity-main-block">
            @include('tags.panels.tags')
        </div>
    </div>
@endsection
