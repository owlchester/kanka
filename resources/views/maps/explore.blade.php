<?php
/**
* @var \App\Models\Map $map
*/
?>

@extends('layouts.map', [
    'title' => $map->name,
    'map' => $map,
])

@section('content')
    @can('update', $map->entity)
        <div class="map-actions absolute bottom-0 right-0 m-2">
            <button class="btn2 btn-mode-enable">
                <x-icon class="plus" />
                {{ __('maps/explore.actions.enter-edit-mode') }}
            </button>
            <button class="btn2 btn-default btn-mode-disable">
                <x-icon class="fa-solid fa-ban" />
                {{ __('maps/explore.actions.exit-edit-mode') }}
            </button>
            <button class="btn2 btn-mode-drawing">
                <x-icon class="pencil" />
                {{ __('maps/explore.actions.finish-drawing') }}
            </button>
        </div>
    @endif
    <div class="map map-explore" id="map{{ $map->id }}" style="width: 100%; height: 100%;">

    </div>

    <input type="hidden" id="ticker-config" data-timeout="20000" data-url="{{ route('maps.ticker', [$campaign, $map]) }}" data-ts="{{ \Carbon\Carbon::now() }}" />
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        var labelShapeIcon = new L.Icon({
            iconUrl: '/images/transparent.png',
            iconSize: [150, 35],
            iconAnchor: [75, 15],
            popupAnchor: [0, -20],
        });

        var markers = [];
        @foreach ($map->markers as $marker)
            @if (!$marker->visible())
                @continue
            @endif

        /** Marker{{ $marker->id }} **/
        var marker{{ $marker->id }} = {!! $marker->exploring()->multiplier($map->is_real)->marker() !!};
            markers.push('marker' + {{ $marker->id }});
        @endforeach

    </script>

    @include('maps._setup', ['editable' => true])

    <script type="text/javascript">
        window.exploreEditMode = false;
        window.drawingPolygon = false;
        window.map = map{{ $map->id }};
        /** Add markers outside of a group directly to the page **/
        @foreach ($map->markers as $marker)
            @if (!$marker->visible())
                @continue
            @endif
            @if(empty($marker->group_id))
                @if ($map->isClustered())
                clusterMarkers{{ $map->id }}.addLayer(marker{{ $marker->id }});
                @else
                marker{{ $marker->id }}.addTo(map{{ $map->id }});
                @endif
            @elseif (!empty($marker->group_id))
                  marker{{ $marker->id }}.addTo(group{{ $marker->group_id }})
            @endif
        @endforeach

    @if ($map->hasDistanceUnit())
    var rulerOptions = {
        lengthUnit: {
            factor: {{ $map->config['distance_measure'] }},
            display: '{{ $map->config['distance_name'] ?? 'Km' }}',
            decimal: 2
        },
    };
    L.control.ruler(rulerOptions).addTo(window.map);
    @endif

    @if ($map->isClustered())
        map{{ $map->id }}.addLayer(clusterMarkers{{ $map->id }});

        /** Add the groups to the cluster **/
        clusterMarkers{{ $map->id }}.checkIn({{ $map->checkinGroups() }});

        /** Add the groups to the map **/
        @foreach ($map->groups as $group)
            @if (!$group->is_shown) @continue @endif
            group{{ $group->id }}.addTo(map{{ $map->id }});
        @endforeach
   @endif

        @can('update', $map->entity)
        map{{ $map->id }}.on('click', function(ev) {
            window.handleExploreMapClick(ev);
        });
    @endcan
    </script>
    <script type="text/javascript">
        @if (!empty($map->grid))
            // Leaflet grid
            @foreach ($map->grids() as $id => $line)
                var polyline{{ $id }} = L.polyline([[{{ $line[0] }}, {{ $line[1] }}],[{{ $line[2] }},
                {{ $line[3] }}]], {color: 'grey', opacity: 0.5}).addTo(map{{ $map->id }});
            @endforeach
        @endif
    </script>
@endsection


@section('styles')
    @parent

    <style>
@foreach ($map->markers as $marker)
    @if ($marker->visible())

        .marker-{{ $marker->id }} {
            @if (!empty($marker->font_colour))
                color: {{ $marker->font_colour }};
            @endif
        }

        .marker-{{ $marker->id }} .marker-pin::after {
            @if (!empty($marker->entity_id) && $marker->entity && $marker->icon == 4)background-image: url('{{ \App\Facades\Avatar::entity($marker->entity)->fallback()->size(276)->thumbnail() }}');

                @if (!empty($marker->pin_size))
                    width: {{ $marker->pinSize(false) - 4 }}px;
                    height: {{ $marker->pinSize(false) - 4 }}px;
                    margin: 2px 0 0 -{{ ceil(($marker->pinSize(false) - 4) / 2) }}px;
                @endif

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
    <x-dialog id="map-marker-modal" loading full></x-dialog>

    @can('update', $map->entity)
    <x-form :action="['maps.map_markers.store', $campaign, $map]" id="map-marker-form">
    <x-dialog
        id="marker-modal"
        :title="__('maps/markers.create.title', ['name' => $map->name])"
        footer="maps.markers._new-footer">
        @include('partials.errors')
        @include('maps.markers._form', ['model' => null, 'map' => $map, 'activeTab' => 1, 'dropdownParent' => '#marker-modal', 'from' => 'explore'])
    </x-dialog>
    </x-form>
@endcan
@endsection
