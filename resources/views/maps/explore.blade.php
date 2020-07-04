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
    <script type="text/javascript">
        var bounds = [[0, 0], [{{ $map->height }}, {{ $map->width }}]];
        var baseLayer = L.imageOverlay('{{ Img::url($map->image) }}', bounds);

@foreach ($map->layers as $layer)
        var layer{{ $layer->id }} = L.imageOverlay('{{ Img::url($layer->image) }}', bounds);
@endforeach

        var baseMaps = {
@foreach ($map->layers as $layer)
            "{{ $layer->name }}": layer{{ $layer->id }},
@endforeach
            "{{ __('maps/layers.base') }}": baseLayer
        }

        var map = L.map('map', {
            crs: L.CRS.Simple,
            center: [{{ floor($map->height / 2)  }}, {{ floor($map->width / 2) }}],
            noWrap: true,
            dragging: true,
            tap: false,
            attributionControl: false,
            zoom: 0,
            minZoom: -3,
            maxZoom: 2,
            layers: [baseLayer]
        });

        L.control.layers(baseMaps).addTo(map);

        var markers = [];
@foreach ($map->markers as $marker)
        var marker{{ $marker->id }} = {!! $marker->exploring()->marker() !!}.addTo(map);
        markers.push('marker' + {{ $marker->id }});
@endforeach

        // Grid
@if (!empty($map->grid))
    @foreach ($map->grids() as $id => $line)
            var polyline{{ $id }} = L.polyline([[{{ $line[0] }}, {{ $line[1] }}],[{{ $line[2] }}, {{ $line[3] }}]], {color: 'black', opacity: 0.5}).addTo(map);
    @endforeach
@endif

        // $('#toggle-tooltips').on('click', function (ev) {
        //     markers.forEach(toggle);
        // });

        function toggle(marker) {
            console.log('marker', marker);
            window[marker].openPopup();

        }

        // map.on('click', function(ev) {
        //     let position = ev.latlng;
        //     console.log('Click', 'lat', Math.floor(position.lat), 'lng', Math.floor(position.lng));
        //     // AJAX request
        //     $('#marker-latitude').val(Math.floor(position.lat));
        //     $('#marker-longitude').val(Math.floor(position.lng));
        //     $('#marker-modal').modal('show');
        // });

        window.map = map;
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
