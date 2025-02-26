<?php /** @var \App\Models\Entity $entity */?>
@extends('layouts.app', [
    'title' => $entity->name . ' - ' . \App\Facades\Module::plural(config('entities.ids.family'), __('entities.families')),
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @if ($mode === \App\Enums\Descendants::Direct)
            <a href="{{ route('families.families', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span>({{ $model->descendants()->has('entity')->count() }})
            </a>
        @else
            <a href="{{ route('families.families', [$campaign, $model, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span>({{ $model->children()->has('entity')->count() }})
            </a>
        @endif
        @include('entities.headers.actions', ['edit' => false])
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
    ])
@endsection
