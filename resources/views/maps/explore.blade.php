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
    @can('update', $map)
        <div class="map-actions absolute bottom-0 right-0 m-2">
            <button class="btn2 btn-warning btn-mode-enable">
                <x-icon class="plus"></x-icon>
                {{ __('maps/explore.actions.enter-edit-mode') }}
            </button>
            <button class="btn2 btn-default btn-mode-disable">
                <x-icon class="fa-solid fa-ban"></x-icon>
                {{ __('maps/explore.actions.exit-edit-mode') }}
            </button>
            <button class="btn2 btn-warning btn-mode-drawing">
                <x-icon class="pencil"></x-icon>
                {{ __('maps/explore.actions.finish-drawing') }}
            </button>
        </div>
    @endif
    <div class="map map-explore" id="map{{ $map->id }}" style="width: 100%; height: 100%;">

    </div>

    <input type="hidden" id="ticker-config" data-timeout="20000" data-url="{{ route('maps.ticker', [$campaign, $map, $campaign]) }}" data-ts="{{ \Carbon\Carbon::now() }}" />
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

    @can('update', $map)
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
            @if (!empty($marker->entity_id) && $marker->entity && $marker->icon == 4)background-image: url('{{ $marker->entity->child->thumbnail(400) }}');

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
<div class="modal fade" id="map-marker-modal" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-base-100">
            <div class="modal-header">
                <span id="map-marker-modal-title"></span>
                <x-dialog.close />
            </div>
            <div class="modal-body bg-base-100" id="map-marker-modal-content">
                <x-icon class="load" />
                <div class="content p-0"></div>
            </div>
        </div>
    </div>
</div>

@can('update', $map)
    <div class="modal fade" id="marker-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content bg-base-100">
                {!! Form::open(['route' => ['maps.map_markers.store', $campaign, $map], 'method' => 'POST', 'data-shortcut' => 1, 'id' => 'map-marker-form', 'class' => 'ajax-subform']) !!}
                    <div class="modal-header">
                        <x-dialog.close :modal="true" />
                        <h4 class="modal-title">
                            {{ __('maps/markers.create.title', ['name' => $map->name]) }}
                        </h4>
                    </div>
                    <div class="modal-body">
                        @include('partials.errors')
                        @include('maps.markers._form', ['model' => null, 'map' => $map, 'activeTab' => 1, 'dropdownParent' => '#marker-modal', 'from' => base64_encode('maps.explore:' . $map->id)])
                    </div>
                    <div class="modal-footer" id="marker-footer">
                        <div class="pull-left">
                            @include('partials.footer_cancel', ['ajax' => true])
                        </div>
                        <div class="submit-group">
                            <input id="submit-mode" type="hidden" value="true"/>
                            <div class="join">
                                <button class="btn2 btn-primary join-item form-submit-main" id="form-submit-main"
                                    data-target="{{ isset($target) ? $target : null }}">
                                    <span>{{ __('crud.save') }}</span>
                                </button>
                                <div class="dropdown dropdown-menu-right">
                                    <button type="button" class="btn2 join-item btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#" class="dropdown-item form-submit-actions">
                                                {{ __('crud.save') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item form-submit-actions"
                                                data-action="submit-update">
                                                {{ __('crud.save_and_update') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item form-submit-actions"
                                                data-action="submit-explore">
                                                {{ __('maps/markers.actions.save_and_explore') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::hidden('from', 'explore') !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endcan
@endsection
