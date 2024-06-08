<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapMarker $model
* @var \App\Models\MapMarker $source
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/markers.create.title', ['name' => $map->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($map->entity)->list(),
        Breadcrumb::show($map),
        __('maps/markers.create.title')
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['maps.map_markers.store', $campaign, $map]" id="map-marker-form" class="ajax-subform">
    <x-box>
        @if (request()->ajax())
            <div class="modal-header">
                <x-dialog.close />
                <h4 class="modal-title">
                    {{ __('maps/markers.create.title', ['name' => $map->name]) }}
                </h4>
            </div>
        @endif
        <div class="map mb-4" id="map{{ $map->id }}" style="width: 100%; height: 100%;"></div>
            @include('partials.errors')


        <x-grid type="1/1">
            @include('maps.markers._form', ['model' => null])
            <x-box.footer>
                <div class="submit-group flex items-center gap-2">
                    <div class="inline-block grow">
                    @include('partials.footer_cancel', ['ajax' => null])
                    </div>
                    @include('maps.markers._actions')
                </div>
            </x-box.footer>
        </x-grid>
    </x-box>
    </x-form>
@endsection

@section('scripts')
    @parent
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    @vite([
        'resources/js/location/map-v3.js',
    ])
    @if (!request()->ajax() && !empty($source))
        @include('maps._setup', ['single' => true, 'model' => $source])
        <script type="text/javascript">
            var labelShapeIcon = new L.Icon({
                iconUrl: '/images/transparent.png',
                iconSize: [150, 35],
                iconAnchor: [75, 15],
                popupAnchor: [0, -20],
            });

            var marker{{ $source->id }} = {!! $source->editing()->marker() !!}.addTo(map{{ $map->id }});

            window.map = map{{ $map->id }};

        </script>
    @endif
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    @vite('resources/sass/map-v3.scss')
@endsection
