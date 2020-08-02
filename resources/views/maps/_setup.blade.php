<?php
/**
 * @var \App\Models\Map $map
 */
?><script type="text/javascript">
    var bounds{{ $map->id }} = [[0, 0], [{{ floor($map->height / 1) }}, {{ floor($map->width / 1) }}]];
    var baseLayer{{ $map->id }} = L.imageOverlay('{{ Img::resetCrop()->url($map->image) }}', bounds{{ $map->id }});

    /** Layers Init **/
@foreach ($map->layers as $layer)
    var layer{{ $layer->id }} = L.imageOverlay('{{ Img::resetCrop()->url($layer->image) }}', bounds{{ $map->id }});
@endforeach

    var baseMaps{{ $map->id }} = {
@foreach ($map->layers as $layer)
        "{{ $layer->name }}": layer{{ $layer->id }},
@endforeach
        "{{ __('maps/layers.base') }}": baseLayer{{ $map->id }}
    }

@if(!isset($single) || !$single)
    /** Groups Init **/
@foreach($map->groups as $group)
    var group{{ $group->id }} = L.layerGroup([{{ $group->markerGroupHtml() }}]);
@endforeach

    var overlayMaps{{ $map->id }} = {
@foreach($map->groups as $group)
        "{{ $group->name }}": group{{ $group->id }},
@endforeach
    }
@else
    var overlayMaps{{ $map->id }} = {};
@endif
    var map{{ $map->id }} = L.map('map{{ $map->id }}', {
        crs: L.CRS.Simple,
        center: [{{ floor($map->height / 2)  }}, {{ floor($map->width / 2) }}],
        noWrap: true,
        dragging: true,
        tap: false,
        attributionControl: false,
        zoom: 0,
        minZoom: -2,
        maxZoom: 5,
        layers: [{{ $map->activeLayers() }}]
    });

    L.control.layers(baseMaps{{ $map->id }}, overlayMaps{{ $map->id }}).addTo(map{{ $map->id }});

</script>
