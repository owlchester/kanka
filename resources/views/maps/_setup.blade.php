<?php
/**
 * @var \App\Models\Map $map
 */
?><script type="text/javascript">
    var bounds = [[0, 0], [{{ floor($map->height / 1) }}, {{ floor($map->width / 1) }}]];
    var baseLayer = L.imageOverlay('{{ Img::resetCrop()->url($map->image) }}', bounds);

    /** Layers Init **/
@foreach ($map->layers as $layer)
    var layer{{ $layer->id }} = L.imageOverlay('{{ Img::resetCrop()->url($layer->image) }}', bounds);
@endforeach

    var baseMaps = {
@foreach ($map->layers as $layer)
        "{{ $layer->name }}": layer{{ $layer->id }},
@endforeach
        "{{ __('maps/layers.base') }}": baseLayer
    }

@if(!isset($single) || !$single)
    /** Groups Init **/
@foreach($map->groups as $group)
    var group{{ $group->id }} = L.layerGroup([{{ $group->markerGroupHtml() }}]);
@endforeach

    var overlayMaps = {
@foreach($map->groups as $group)
        "{{ $group->name }}": group{{ $group->id }},
@endforeach
    }
@else
    var overlayMaps = {};
@endif
    var map = L.map('map', {
        crs: L.CRS.Simple,
        center: [{{ floor($map->height / 2)  }}, {{ floor($map->width / 2) }}],
        noWrap: true,
        dragging: true,
        tap: false,
        attributionControl: false,
        zoom: 0,
        minZoom: -2,
        maxZoom: 5,
        layers: [baseLayer]
    });

    L.control.layers(baseMaps, overlayMaps).addTo(map);

</script>
