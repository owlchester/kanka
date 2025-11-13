<?php
/**
 * @var \App\Models\Map $map
 */
$focus = $map->centerFocus();

if (isset($single) && $single) {
    $focus = "$model->latitude, $model->longitude";
} elseif (request()->has('lat') && request()->has('lng')) {
    $focus = ((float) request()->get('lat')) . ', ' . ((float) request()->get('lng'));
} elseif (request()->has('focus')) {
    /** @var \App\Models\MapMarker $pin */
    $pin = $map->markers->where('id', request()->get('focus', 0))->first();
    if ($pin) {
        $focus = "$pin->latitude, $pin->longitude";
    }
}

function renderGroupTree($groups) {
    $output = '';

    foreach ($groups as $group) {
        $children = $group->children;
        $output .= '{';
        $output .= 'label: "' . e($group->name) . '", ';
        $output .= 'layer: group' . $group->id . ', ';
        if ($children) {
            //  $output .= 'selectAllCheckbox: true,';
            $output .= 'children: [' . renderGroupTree($children) . ']';
        }
        $output .= '},';
    }

    return $output;
}

?>
<script type="text/javascript">
    /** Kanka map {{ $map->id }} setup **/
    var bounds{{ $map->id }} = {{ $map->bounds() }};
    var maxBounds{{ $map->id }} = {{ $map->bounds(true) }};
    @if ($map->isReal())
    var baseLayer{{ $map->id }} = L.imageOverlay('', bounds{{ $map->id }});
    @else
    var baseLayer{{ $map->id }} = L.imageOverlay('{{ \App\Facades\Avatar::entity($map->entity)->original() }}', bounds{{ $map->id }});
    @endif

    /** Layers Init **/
@foreach ($map->layers as $layer)
    @if (!$layer->hasImage())
        @continue
    @endif
    @if ($layer->image)
        var layer{{ $layer->id }} = L.imageOverlay('{{ $layer->image->url() }}', bounds{{ $map->id }});
    @else
        var layer{{ $layer->id }} = L.imageOverlay('{{ Storage::url($layer->image_path) }}', bounds{{ $map->id }});
    @endif
@endforeach

    var baseMaps{{ $map->id }} = [
@foreach ($map->layers->where('type_id', '<', 1)->sortBy('position') as $layer)
@if (!$layer->hasImage()) @continue @endif
        {
        label: '{{ $layer->name }}',
        layer: layer{{ $layer->id }},
        },
@endforeach
        {
        label: "{{ __('maps/layers.base') }}",
        layer: baseLayer{{ $map->id }},
        },
    ];

@if(!isset($single) || !$single)
    /** Groups Init **/
@foreach($map->groups as $group)
    @if ($map->isClustered())
    var group{{ $group->id }} = L.layerGroup(/**[{{ $group->markerGroupHtml() }}]**/);
    @else
    var group{{ $group->id }} = L.layerGroup([{{ $group->markerGroupHtml() }}]);
    @endif
@endforeach

    var overlayMaps{{ $map->id }} = {
        label: "{{ __('maps.panels.groups') }}",
        selectAllCheckbox: 'True',
        children: [
@foreach($map->layers->where('type_id', '>', 0)->sortBy('position') as $layer)
@if (!$layer->hasImage()) @continue @endif
    {
       label: "{{ $layer->name }} ({{ $layer->position }})",
       layer: layer{{ $layer->id }},
    },
@endforeach
    {!! renderGroupTree($map->groups->whereNull('parent_id')->sortBy('position')) !!}
        ],
    }
@else
    var overlayMaps{{ $map->id }} = {};
@endif
    @if (!$map->isReal() && !$map->isChunked())

    var map{{ $map->id }} = L.map('map{{ $map->id }}', {
        crs: L.CRS.Simple,
        center: [ {{ $focus }} ],
        noWrap: true,
        maxBounds: maxBounds{{ $map->id }},
        maxBoundsViscosity: 0.5,
        dragging: true,
        tap: false,
        attributionControl: false,
        zoom: {{ $map->initialZoom() }},
        zoomSnap: 0.25,
        minZoom: {{ $map->minZoom() }},
        maxZoom: {{ $map->maxZoom() }},
        layers: [{{ $map->activeLayers(!isset($single)) }}],
        @if (isset($editable) && $editable)
        editable: true,
        @endif
    });

    L.control.layers.tree(baseMaps{{ $map->id }}, overlayMaps{{ $map->id }}).addTo(map{{ $map->id }});
    @else

    var map{{ $map->id }} = L.map('map{{ $map->id }}', {
        @if ($map->isChunked())
        crs: L.CRS.Simple,
        maxBounds: maxBounds{{ $map->id }},
        maxBoundsViscosity: 0.5,
        @endif
        noWrap: true,
        dragging: true,
        tap: false,
        attributionControl: false,
        minZoom: {{ $map->minZoom() }},
        maxZoom: {{ $map->maxZoom() }},
        @if (isset($editable) && $editable)
        editable: true,
        @endif
    }).setView([ {{ $focus }} ], {{ $map->initialZoom() }});

    @if ($map->isReal())
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map{{ $map->id }});
    @else
    L.tileLayer('{{ route('maps.chunks', [$campaign, $map->id]) }}/?z={z}&x={x}&y={y}', {
        attribution: '&copy; Kanka',
    }).addTo(map{{ $map->id }});
    @endif

    L.control.layers.tree(null, overlayMaps{{ $map->id }}).addTo(map{{ $map->id }});

    @endif

    @if ($map->isClustered())
    // This is where we group markers into cluster groups
    var clusterMarkers{{ $map->id }} = L.markerClusterGroup.layerSupport({ chunkedLoading: true });
    @endif
</script>
