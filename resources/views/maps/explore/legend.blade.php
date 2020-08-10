<?php
/**
 * @var \App\Models\Map $map
 * @var \App\Models\MapMarker $marker
 */
?>
<h4>{{ __('locations.map.legend') }}</h4>
<ul>
    @foreach ($map->legendMarkers() as $marker)
        <li>
            <a href="#" class="map-legend-marker" data-lng="{{ $marker['longitude'] }}" data-lat="{{ $marker['latitude'] }}" data-id="marker{{ $marker['id'] }}">{{ $marker['name'] }}</a>
        </li>
    @endforeach
</ul>
