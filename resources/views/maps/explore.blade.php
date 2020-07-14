<?php /**
 * @var \App\Models\Map $map
 */
?>
@extends('layouts.map', [
    'title' => $map->name,
    'map' => $map,
])

@section('content')

    <div class="map map-explore" id="map" style="width: 100%; height: 100%;">
{{--        <a href="#" class="btn btn-primary btn-map-explore" id="toggle-tooltips">--}}
{{--            {{ __('maps.actions.toggle') }}--}}
{{--        </a>--}}
    </div>

@endsection

@section('scripts')
    @parent
    @include('maps._setup')
    <script type="text/javascript">
        var markers = [];
@foreach ($map->markers as $marker)
        var marker{{ $marker->id }} = {!! $marker->exploring()->marker() !!}.addTo(map);
        markers.push('marker' + {{ $marker->id }});
@endforeach
    </script>
    <script type="text/javascript">
@if (!empty($map->grid))
        // Leaflet grid
@foreach ($map->grids() as $id => $line)
        var polyline{{ $id }} = L.polyline([[{{ $line[0] }}, {{ $line[1] }}],[{{ $line[2] }}, {{ $line[3] }}]], {color: 'grey', opacity: 0.5}).addTo(map);
@endforeach

@endif

{{--@if (!empty($map->distance_measure))--}}
{{--        // Distance calculator--}}
{{--        L.control.polylineMeasure({unit: 'meters', unitControlLabel: {custom: '{{ $map->distance_name ?? 'custom' }}'}, customUnitDistance: {{ $map->distance_measure }}}).addTo(map);--}}
{{--@endif--}}

        // Map ticker to update markers every 20 seconds
        var tickerTimeout = 2000;
        var tickerUrl = '{{ route('maps.ticker', $map) }}';
        var tickerTs = '{{ \Carbon\Carbon::now() }}';
        $(document).ready(function () {
            setTimeout(mapTicker, tickerTimeout);
            setTimeout(mapRedraw(), 1000);
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

        function mapRedraw() {
            console.log('redraw');
            window.map.invalidateSize(true);
        }
    </script>
@endsection


@section('styles')
    @parent

    <style>
@foreach ($map->markers as $marker)
        .marker-{{ $marker->id }}  {
            background-color: {{ $marker->colour ?? 'unset' }};
        @if ($marker->entity && $marker->icon == 4)
            background-image: url({{ $marker->entity->child->getImageUrl(400) }});
        @endif
}
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
