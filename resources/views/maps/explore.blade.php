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
