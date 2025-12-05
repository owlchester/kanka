<?php
/**
 * @var \App\Models\Map $map
 * @var \App\Models\MapMarker $marker
 */
?>
<h4 class="text-sidebar-content flex gap-2 items-center text-lg">
    <span class="">{{ __('maps.panels.legend') }}</span>
    <button class="btn2 btn-xs btn-ghost" data-animate="collapse" data-target=".map-legend-group-markers" data-toggle="tooltip" data-title="{{ __('maps/explore.toggle') }}">
        <x-icon class="fa-regular fa-folder-tree" />
    </button>
</h4>
<ul>
    @foreach ($map->legendMarkers(false) as $marker)
        <li>
            @if(isset($marker['markers']))
                <a href="#" class="map-legend-group" data-animate="collapse" data-target=".map-legend-group-{{ $marker['id'] }}">
                    <span class="map-legend-group-{{ $marker['id'] }}"><x-icon class="fa-regular fa-folder-open" /></span>
                    <span class="hidden map-legend-group-{{ $marker['id'] }}"><x-icon class="fa-regular fa-folder" /></span>
                    {!! $marker['name'] !!}
                </a>

                <ul class="overflow-hidden map-legend-group-markers map-legend-group-{{ $marker['id'] }}" >
                    @foreach ($marker['markers'] as $mk)
                        <li>
                            <a href="#" class="map-legend-marker" data-lng="{{ $mk['longitude'] }}" data-lat="{{ $mk['latitude'] }}" data-id="marker{{ $mk['id'] }}">
                                {!! $mk['name'] !!}
                                @if (\Illuminate\Support\Arr::has($marker, 'visibility')) {!! $marker['visibility'] !!}@endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <a href="#" class="map-legend-marker " data-lng="{{ $marker['longitude'] }}" data-lat="{{ $marker['latitude'] }}" data-id="marker{{ $marker['id'] }}">
                    {!! stripcslashes($marker['name']) !!}
                    @includeWhen(\Illuminate\Support\Arr::has($marker, 'visibility'), 'icons.visibility', ['icon' => $marker['visibility']])
                </a>
            @endif
        </li>
    @endforeach
</ul>

