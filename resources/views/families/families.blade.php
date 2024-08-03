<?php /** @var \App\Models\Family $model */?>
@extends('layouts.app', [
    'title' => $model->name . ' - ' . \App\Facades\Module::plural(config('entities.ids.family'), __('entities.families')),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @if (request()->has('parent_id'))
            <a href="{{ route('families.families', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span>({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('families.families', [$campaign, $model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span>({{ $model->children()->count() }})
            </a>
        @endif
    </div>
@endsection

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.family'), __('entities.families'));
@endphp
@section('content')
    @include('entities.pages.subpage', [
        'active' => 'families',
        'breadcrumb' => $plural,
        'view' => 'families.panels.families',
        'entity' => $model->entity,
    ])
@endsection
