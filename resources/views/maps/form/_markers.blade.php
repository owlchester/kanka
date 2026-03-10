<?php
/**
* @var \App\Models\MapMarker $marker
* @var \App\Models\Map $model
*/
?>
@if (!isset($model) || !$model->explorable())
    <x-alert type="warning">
        <p>{{ __('maps.helpers.missing_image') }}</p>
    </x-alert>
@else
    <x-tutorial code="map_markers" doc="https://docs.kanka.io/en/latest/entries/maps/markers.html">
        <p>{{ __('maps/markers.helpers.base') }}</p>
    </x-tutorial>

    <div class="map" id="map{{ $model->id }}" style="width: 100%; height: 50%;">
        <div class="map-actions absolute bottom-0 right-0 m-4">
            <button class="btn2 btn-sm btn-mode-drawing">
                <x-icon class="pencil" />
                {{ __('maps/explore.actions.finish-drawing') }}
            </button>
        </div>
    </div>

@section('scripts')
    @parent
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="{{ 'https://unpkg.com/leaflet@' . config('app.leaflet_source') . '/dist/leaflet.js' }}" integrity="{{ config('app.leaflet_js') }}" crossorigin=""></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.zoomdisplay.js" type="text/javascript" ></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.markercluster.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.markercluster.layersupport.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.path.drag.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.editable.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.zoomcss.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.layerstree.js"></script>
    @vite([
        'resources/js/location/map-v3.js',
    ])

    <script type="text/javascript">
        var labelShapeIcon = new L.Icon({
            iconUrl: '/images/transparent.png',
            iconSize: [150, 35],
            iconAnchor: [75, 15],
            popupAnchor: [0, -20],
        });

        var markers = {};
        @foreach ($model->markers as $marker)
            var marker{{ $marker->id }} = {!! $marker->multiplier($model->is_real)->marker() !!};
        @endforeach

    </script>
    @include('maps._setup', ['map' => $model, 'editable' => true])

    <script type="text/javascript">
        window.map = map{{ $model->id }};
        //window.map
        window.exploreEditMode = true;
        /** Add markers outside of a group directly to the page **/
        @foreach ($model->markers as $marker)
            @if ($marker->visible() && empty($marker->group_id))
                @if ($model->isClustered())
                    clusterMarkers{{ $model->id }}.addLayer(marker{{ $marker->id }});
                @else
                    marker{{ $marker->id }}.addTo(map{{ $model->id }});
                @endif
            @elseif (!empty($marker->group_id))
                marker{{ $marker->id }}.addTo(group{{ $marker->group_id }})
            @endif
        @endforeach

        @if ($model->isClustered())
            map{{ $model->id }}.addLayer(clusterMarkers{{ $model->id }});

            /** Add the groups to the cluster **/
            clusterMarkers{{ $model->id }}.checkIn({{ $model->checkinGroups() }});

            /** Add the groups to the map **/
            @foreach ($model->groups as $group)
                @if (!$group->is_shown) @continue @endif
                group{{ $group->id }}.addTo(map{{ $model->id }});
            @endforeach
        @endif

        map{{ $model->id }}.on('click', function(ev) {
            window.handleExploreMapClick(ev);
        });

        window.map = map{{ $model->id }};

    </script>
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.layerstree.css"/>
    <link rel="stylesheet" href="{{ 'https://unpkg.com/leaflet@' . config('app.leaflet_source') . '/dist/leaflet.css' }}" integrity="{{ config('app.leaflet_css') }}" crossorigin="" />
    @vite('resources/css/maps/maps.css')

    <style>
        @foreach ($model->markers as $marker)
        .marker-{{ $marker->id }} {
            @if (!empty($marker->font_colour))color: {{ $marker->font_colour }};
            @endif
        }

        @if ($marker->entity && $marker->icon == 4).marker-{{ $marker->id }} .marker-pin::after {
            background-image: url('{{ \App\Facades\Avatar::entity($marker->entity)->fallback()->size(276)->thumbnail() }}');
            @if (!empty($marker->pin_size))width: {{ $marker->pinSize(false) - 4 }}px;
            height: {{ $marker->pinSize(false) - 4 }}px;
            margin: 2px 0 0 -{{ ceil(($marker->pinSize(false) - 4) / 2) }}px;
            @endif
        }

        @endif
        @if (!empty($marker->pin_size)).marker-{{ $marker->id }} .marker-pin {
            width: {{ $marker->pinSize() }};
            height: {{ $marker->pinSize() }};
            margin: -{{ $marker->pinSize(false) / 2 }}px 0 0 -{{ $marker->pinSize(false) / 2 }}px;
        }

        .marker-{{ $marker->id }} i {
            font-size: {{ $marker->pinSize(false) / 2 }}px;
        }

        @endif

        @endforeach

    </style>
@endsection

@section('modals')
    @parent
    <x-form :action="['maps.map_markers.store', $campaign, $model]">
    <x-dialog
        id="marker-modal"
        :title="__('maps/markers.create.title', ['name' => $model->name])"
        footer="maps.markers._new-footer">
        @include('maps.markers._form', ['model' => null, 'map' => $model, 'activeTab' => 1, 'dropdownParent' => '#marker-modal', 'from' => base64_encode('maps.map_markers.index:' . $model->id)])
    </x-dialog>
    </x-form>
@endsection

@endif
