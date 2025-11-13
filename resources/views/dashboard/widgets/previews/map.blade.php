<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Map $map
 * @var \App\Models\Entity $entity
 */
$map = $entity->child;
?>


@if(!$map->explorable())
    <x-alert type="warning">
        <a href="{{ $entity->url() }}">{!! $entity->name !!}</a>
        <p class="">{{ __('maps.errors.dashboard.missing') }}</p>
    </x-alert>
    @php return @endphp
@endif

<div class="widget-map">
    <div class="map map-dashboard rounded" id="map{{ $map->id }}" style="width: 100%; height: 100%;">
        <a href="{{ route('maps.explore', [$campaign, $map]) }}" class="btn2 btn-primary btn-xs btn-map-explore z-[820] absolute bottom-3 right-3">
            <x-icon class="map" />
            {{ __('maps.actions.explore') }}
        </a>
    </div>
</div>



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
            var marker{{ $marker->id }} = {!! $marker->multiplier($map->is_real)->marker() !!};
            markers.push('marker' + {{ $marker->id }});
        @endforeach
    </script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.layerstree.js"></script>
    @include('maps._setup')

    <script type="text/javascript">
        /** Add markers outside a group directly to the page **/
        @foreach ($map->markers as $marker)
            @if (!$marker->visible())
                @continue
            @endif
            @if ($marker->visible() && empty($marker->group_id))
                @if ($map->isClustered())
                    clusterMarkers{{ $map->id }}.addLayer(marker{{ $marker->id }});
                @else
                    marker{{ $marker->id }}.addTo(map{{ $map->id }});
                @endif
            @elseif (!empty($marker->group_id))
                marker{{ $marker->id }}.addTo(group{{ $marker->group_id }})
            @endif
        @endforeach

        @if ($map->isClustered())
            map{{ $map->id }}.addLayer(clusterMarkers{{ $map->id }});

            /** Add the groups to the cluster **/
            clusterMarkers{{ $map->id }}.checkIn({{ $map->checkinGroups() }});

            /** Add the groups to the map **/
            @foreach ($map->groups as $group)
                @if (!$group->is_shown)
                    @continue
                @endif
                group{{ $group->id }}.addTo(map{{ $map->id }});
            @endforeach
        @endif

        @foreach ($map->markers as $marker)
            @if(!$marker->visible())
                @continue
            @endif
            @if (empty($marker->group_id))
                marker{{ $marker->id }}.addTo(map{{ $map->id }});
            @endif
        @endforeach
    </script>
@endsection



@section('styles')
    @parent
    <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.layerstree.css"/>
    <style>
        @foreach ($map->markers as $marker)
            @if(!$marker->visible())
                @continue
            @endif
            .marker-{{ $marker->id }}  {
                @if(!empty($marker->font_colour))
                    color: {{ $marker->font_colour }};
                @endif
            }

            @if ($marker->entity && $marker->icon == 4)
                .marker-{{ $marker->id }} .marker-pin::after {
                    background-image: url('{{ \App\Facades\Avatar::entity($marker->entity)->fallback()->size(276)->thumbnail() }}');
                    @if(!empty($marker->pin_size))
                        width: {{ $marker->pinSize(false) - 4 }}px;
                        height: {{ $marker->pinSize(false) - 4 }}px;
                        margin: 2px 0 0 -{{ ceil(($marker->pinSize(false)-4)/2) }}px;
                    @endif
                }
            @endif

            @if(!empty($marker->pin_size))
                .marker-{{ $marker->id }} .marker-pin {
                    width: {{ $marker->pinSize() }};
                    height: {{ $marker->pinSize() }};
                    margin: -{{ $marker->pinSize(false) / 2 }}px 0 0 -{{ $marker->pinSize(false) / 2 }}px;
                }
                .marker-{{ $marker->id }} i {
                    font-size: {{ $marker->pinSize(false) / 2 }}px;
                }
            @endif
        @endforeach
    </style>
@endsection
