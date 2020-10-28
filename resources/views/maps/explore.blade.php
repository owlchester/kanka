<?php /**
 * @var \App\Models\Map $map
 */
?>
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
@endif
        }
        @endif
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
@endsection
