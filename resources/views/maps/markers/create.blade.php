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
        Breadcrumb::campaign($campaign)->entity($map->entity)->list(),
        Breadcrumb::show(),
        __('maps/markers.create.title')
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['maps.map_markers.store', $campaign, $map]" id="map-marker-form">
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
                <div class="submit-group flex items-center justify-between gap-2">
                    <div class="">
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
    <script src="{{ 'https://unpkg.com/leaflet@' . config('app.leaflet_source') . '/dist/leaflet.js' }}" integrity="{{ config('app.leaflet_js') }}" crossorigin=""></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.markercluster.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.zoomdisplay.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.zoomcss.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.markercluster.layersupport.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.path.drag.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.editable.js"></script>
    @vite([
        'resources/js/location/map-v3.js',
    ])
    @if (!request()->ajax() && !empty($source))
        @include('maps._setup', ['single' => true, 'model' => $source, 'editable' => true])
        <script type="text/javascript">
            var labelShapeIcon = new L.Icon({
                iconUrl: '/images/transparent.png',
                iconSize: [150, 35],
                iconAnchor: [75, 15],
                popupAnchor: [0, -20],
            });

            var marker{{ $source->id }} = {!! $source->editing()->multiplier($map->isReal())->marker() !!}.addTo(map{{ $map->id }});
            @if ($source->isPolygon())
                window.polygon = marker{{ $source->id }};
                window.polygon.enableEdit();
                window.polygon.on('editable:dragend', markerUpdateHandler);
                window.polygon.on('editable:vertex:dragend', markerUpdateHandler);
                window.polygon.on('editable:vertex:dragend', markerUpdateHandler);
            @endif

            window.map = map{{ $map->id }};

            @if ($source->isPolygon())
            function markerUpdateHandler(data) {
                window.markerUpdateHandler(data)
            }
            @endif

        </script>
    @endif
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ 'https://unpkg.com/leaflet@' . config('app.leaflet_source') . '/dist/leaflet.css' }}" integrity="{{ config('app.leaflet_css') }}" crossorigin="" />
    @vite('resources/css/maps/maps.css')
@endsection
