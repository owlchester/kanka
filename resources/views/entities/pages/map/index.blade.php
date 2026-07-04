@extends('layouts.rich', [
    'title' => $entity->name,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'pageClass' => 'map-page',
])

@section('content')
    <div id="map-explorer">
        <map-explorer
            api="{{ route('entities.map-api', [$campaign, $entity]) }}"
            loading-text="{{ __('maps/explorer.loading') }}"
            error-text="{{ __('maps/explorer.errors.load') }}"
            :can-edit="@can('update', $entity) true @else false @endcan"
            :boosted="@if ($campaign->boosted()) true @else false @endif"
        ></map-explorer>
    </div>
@endsection

@section('scripts')
    @parent
    @vite('resources/js/maps/explore.js')
@endsection
