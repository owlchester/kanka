@extends('layouts.rich', [
    'title' => $entity->name,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'pageClass' => 'map-page',
])

@section('content')
    <div id="map-explorer">
        <map-explorer api="{{ route('entities.map-api', [$campaign, $entity]) }}"></map-explorer>
    </div>
@endsection

@section('scripts')
    @parent
    @vite('resources/js/maps/explore.js')
@endsection
