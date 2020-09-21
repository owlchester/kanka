<?php
/**
 * @var \App\Models\Map $map
 */
?><script type="text/javascript">
    var bounds{{ $map->id }} = [[0, 0], [{{ floor($map->height / 1) }}, {{ floor($map->width / 1) }}]];
    var baseLayer{{ $map->id }} = L.imageOverlay('{{ Storage::url($map->image) }}', bounds{{ $map->id }});

    /** Layers Init **/
@foreach ($map->layers as $layer)
    var layer{{ $layer->id }} = L.imageOverlay('{{ Storage::url($layer->image) }}', bounds{{ $map->id }});
@endforeach

    var baseMaps{{ $map->id }} = {
@foreach ($map->layers->where('type_id', '<', 1) as $layer)
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
@foreach($map->layers->where('type_id', '>', 0) as $layer)
        "{{ $layer->name }}": layer{{ $layer->id }},
@endforeach
@foreach($map->groups as $group)
        "{{ $group->name }}": group{{ $group->id }},
@endforeach
    }
@else
    var overlayMaps{{ $map->id }} = {};
@endif
    var map{{ $map->id }} = L.map('map{{ $map->id }}', {
        crs: L.CRS.Simple,
        center: [ @if(isset($single) && $single) {{ $model->latitude }}, {{ $model->longitude }} @else {{ $map->centerFocus() }} @endif ],
        noWrap: true,
        dragging: true,
        tap: false,
        attributionControl: false,
        zoom: {{ $map->initialZoom() }},
        zoomSnap: 0.25,
        minZoom: {{ $map->minZoom() }},
        maxZoom: {{ $map->maxZoom() }},
        layers: [{{ $map->activeLayers(!isset($single)) }}]
    });

    L.control.layers(baseMaps{{ $map->id }}, overlayMaps{{ $map->id }}).addTo(map{{ $map->id }});

</script>
