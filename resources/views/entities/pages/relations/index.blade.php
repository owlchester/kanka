<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'bodyClass' => 'entity-relations'
])


@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        <x-learn-more url="features/connections.html" />
        @if ($mode == 'map' || (empty($mode) && $campaign->boosted()))
            <a href="{{ route('entities.relations.index', [$campaign, $entity, 'mode' => 'table']) }}" class="btn2 btn-sm" data-toggle="tooltip" data-title="{{ __('entities/relations.actions.mode-table') }}">
                <x-icon class="fa-regular fa-list-ul" />
            </a>
        @else
            <a href="{{ route('entities.relations.index', [$campaign, $entity, 'mode' => 'map']) }}" class="btn2 btn-sm" data-toggle="tooltip" data-title="{{ __('entities/relations.actions.mode-map') }}">
                <x-icon class="map" />
            </a>
        @endif
        @include('entities.pages.relations._buttons')
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection



@section('content')

    @include('entities.pages.subpage', [
        'active' => 'relations',
        'view' => 'entities.pages.relations.render',
        'entity' => $entity,
    ])
@endsection
