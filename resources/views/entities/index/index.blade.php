@extends('layouts.app', [
    'title' => $entityType->plural(),
    'seoTitle' => $entityType->plural() . ' - ' . $campaign->name,
    'breadcrumbs' => false,
    'canonical' => true,
    'bodyClass' => 'kanka-' . $entityType->code,
])

@section('entity-header')
    <div class="flex gap-2 items-center mb-5">
        <h1 class="grow text-4xl category-title truncate">{!! $entityType->plural() !!}</h1>
        <div class="flex flex-wrap gap-2 justify-end">
            @include('layouts.datagrid._togglers', ['route' => 'entities.index'])
            @includeWhen(isset($actions), 'entities.index._actions')
            @can('create', [$entityType, $campaign])
                @include('entities.index._create')
            @endcan
        </div>
    </div>
@endsection

@section('content')
    @include('partials.errors')

    @include('ads.top')

    <div class="flex flex-col gap-5">
    @if (auth()->guest())
        <div class="text-muted grow">
            <x-icon class="fa-solid fa-filter" />
            {{ __('filters.helpers.guest') }}
        </div>
    @else
        <div class="flex flex-stretch gap-2 items-center">
            @include('layouts.datagrid.search', ['route' => ['entities.index', $campaign, $entityType]])
            @include('cruds.datagrids.filters.datagrid-filter', ['route' => ['entities.index', $campaign, $entityType]])
        </div>
    @endif

        @include('cruds.datagrids.explore', ['route' => 'entities.index'])

    </div>
@endsection

@section('modals')
    @parent
    @includeWhen(auth()->check(), 'cruds.datagrids.bulks.modals')
@endsection


