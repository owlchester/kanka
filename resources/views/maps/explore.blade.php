<?php /**
 * @var \App\Models\Map $map
 */
?>
@inject('campaign', 'App\Services\CampaignService')

@extends('layouts.map', [
    'title' => $map->name,
    'map' => $map,
])

@section('content')
    <div class="map map-explore" id="map{{ $map->id }}" style="width: 100%; height: 100%;">
    </div>

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
@if(!$marker->visible())
@continue
@endif
        var marker{{ $marker->id }} = {!! $marker->exploring()->marker() !!};
        markers.push('marker' + {{ $marker->id }});
@endforeach
    </script>

    @include('maps._setup')

    <script type="text/javascript">
        window.map = map{{ $map->id }};
@foreach ($map->markers as $marker)
@if ($marker->visible() && empty($marker->group_id))
        marker{{ $marker->id }}.addTo(map{{ $map->id }});
@endif
@endforeach

        @can('update', $map)
        map{{ $map->id }}.on('click', function(ev) {
            let position = ev.latlng;
            //console.log('Click', 'lat', position.lat, 'lng', position.lng);
            // AJAX request
            //console.log('do', "$('#marker-latitude').val(" + position.lat.toFixed(3) + ");");
            $('#marker-latitude').val(position.lat.toFixed(3));
            $('#marker-longitude').val(position.lng.toFixed(3));
            $('#marker-modal').modal('show');
        });
        @endcan
    </script>

    <script type="text/javascript">
@if (!empty($map->grid))
        // Leaflet grid
@foreach ($map->grids() as $id => $line)
        var polyline{{ $id }} = L.polyline([[{{ $line[0] }}, {{ $line[1] }}],[{{ $line[2] }}, {{ $line[3] }}]], {color: 'grey', opacity: 0.5}).addTo(map{{ $map->id }});
@endforeach
@endif

{{--@if (!empty($map->distance_measure))--}}
{{--        // Distance calculator--}}
{{--        L.control.polylineMeasure({unit: 'meters', unitControlLabel: {custom: '{{ $map->distance_name ?? 'custom' }}'}, customUnitDistance: {{ $map->distance_measure }}}).addTo(map);--}}
{{--@endif--}}

        // Map ticker to update markers every 20 seconds
        var tickerTimeout = 20000;
        var tickerUrl = '{{ route('maps.ticker', $map) }}';
        var tickerTs = '{{ \Carbon\Carbon::now() }}';
        $(document).ready(function () {
            setTimeout(mapTicker, tickerTimeout);
            // setTimeout(mapRedraw(), 1000);
        });

        function mapTicker() {
            $.ajax(tickerUrl + '?ts=' + tickerTs)
            .done(function (data) {
                if (!data) {
                    return;
                }
                tickerTs = data.ts;
                for (var id in data.markers) {
                    let changedMarker = data.markers[id];
                    //console.log('moving', 'marker' + changedMarker.id, changedMarker);
                    window['marker' + changedMarker.id].setLatLng({lon: changedMarker.longitude, lat: changedMarker.latitude}).update();
                }
                setTimeout(mapTicker, tickerTimeout);
            });
        }
        //
        // function mapRedraw() {
        //     console.log('redraw');
        //     window.map.invalidateSize(true);
        // }
    </script>
@endsection


@section('styles')
    @parent

    <style>
@foreach ($map->markers as $marker)
@if ($marker->visible())
        .marker-{{ $marker->id }}  {
@if(!empty($marker->font_colour))
            color: {{ $marker->font_colour }};
@endif
        }
        .marker-{{ $marker->id }} .marker-pin::after {
@if ($marker->entity && $marker->icon == 4)
            background-image: url({{ $marker->entity->child->getImageUrl(400) }});
        @if(!empty($marker->pin_size))
            width: {{ $marker->pinSize(false) - 4 }}px;
            height: {{ $marker->pinSize(false) - 4 }}px;
            margin: 2px 0 0 -{{ ceil(($marker->pinSize(false)-4)/2) }}px;
        @endif
@endif
        }
        @endif


@if(!empty($marker->pin_size))
        .marker-{{ $marker->id }} .marker-pin {
            width: {{ $marker->pinSize() }};
            height: {{ $marker->pinSize() }};
            margin: -{{ $marker->pinSize(false) / 2 }}px 0 0 -{{ $marker->pinSize(false) / 2 }}px;
        }
        .marker-{{ $marker->id }} i {
            font-size: {{ $marker->pinSize(false) / 2 }}px;
        }@endif
@endforeach
    </style>
@endsection

@section('modals')
    <div class="modal fade" id="map-marker-modal" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span id="map-marker-modal-title"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="map-marker-modal-content">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
    </div>

    @can('update', $map)
        <div class="modal fade" id="marker-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                            <h4>
                                {{ __('maps/markers.create.title', ['name' => $map->name]) }}
                            </h4>
                        </div>
                        <div class="panel-body">

                            {!! Form::open(['route' => ['maps.map_markers.store', $map],
                                'method' => 'POST',
                                'data-shortcut' => 1,
                                'enctype' => 'multipart/form-data',
                                'id' => 'map-marker-new-form'
                               ]) !!}
                            @include('maps.markers._form', ['model' => null, 'map' => $map, 'activeTab' => 1])

                            <div class="form-group">
                                <button class="btn btn-success"><i class="fa fa-spin fa-spinner" style="display:none;"></i><span>{{ __('crud.save') }}</span></button>
                            </div>

                            {!! Form::hidden('from', 'explore') !!}

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
