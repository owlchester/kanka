<?php
/**
* @var \App\Models\MapMarker $marker
* @var \App\Models\Map $model
*/
?>
@if (!isset($model) || empty($model->image))
    <x-alert type="warning">
        <p>{{ __('maps.helpers.missing_image') }}</p>
    </x-alert>
@else
    <x-tutorial code="map_markers" doc="https://docs.kanka.io/en/latest/entities/maps/markers.html">
        <p>{{ __('maps/markers.helpers.base') }}</p>
    </x-tutorial>

    <div class="map" id="map{{ $model->id }}" style="width: 100%; height: 50%;">
        <div class="map-actions absolute bottom-0 right-0 m-4">
            <button class="btn2 btn-accent btn-sm btn-mode-drawing">
                <x-icon class="pencil"></x-icon>
                {{ __('maps/explore.actions.finish-drawing') }}
            </button>
        </div>
    </div>

@section('scripts')
    @parent
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="/js/vendor/leaflet/leaflet.markercluster.js"></script>
    <script src="/js/vendor/leaflet/leaflet.markercluster.layersupport.js"></script>
    <script src="/js/vendor/leaflet/leaflet.path.drag.js"></script>
    <script src="/js/vendor/leaflet/leaflet.editable.js"></script>
    @vite([
        'resources/js/location/map-v3.js',
    ])

    <script type="text/javascript">
        var labelShapeIcon = new L.Icon({
            iconUrl: '/images/transparent.png',
            iconSize: [150, 35],
            iconAnchor: [75, 15],
            popupAnchor: [0, -20],
        });

        var markers = {};
        @foreach ($model->markers as $marker)
            var marker{{ $marker->id }} = {!! $marker->multiplier($model->is_real)->marker() !!};
        @endforeach

    </script>
    @include('maps._setup', ['map' => $model, 'editable' => true])

    <script type="text/javascript">
        window.map = map{{ $model->id }};
        //window.map
        window.exploreEditMode = true;
        /** Add markers outside of a group directly to the page **/
        @foreach ($model->markers as $marker)
            @if ($marker->visible() && empty($marker->group_id))
                @if ($model->isClustered())
                    clusterMarkers{{ $model->id }}.addLayer(marker{{ $marker->id }});
                @else
                    marker{{ $marker->id }}.addTo(map{{ $model->id }});
                @endif
            @elseif (!empty($marker->group_id))
                marker{{ $marker->id }}.addTo(group{{ $marker->group_id }})
            @endif
        @endforeach

        @if ($model->isClustered())
            map{{ $model->id }}.addLayer(clusterMarkers{{ $model->id }});

            /** Add the groups to the cluster **/
            clusterMarkers{{ $model->id }}.checkIn({{ $model->checkinGroups() }});

            /** Add the groups to the map **/
            @foreach ($model->groups as $group)
                @if (!$group->is_shown) @continue @endif
                group{{ $group->id }}.addTo(map{{ $model->id }});
            @endforeach
        @endif

        map{{ $model->id }}.on('click', function(ev) {
            window.handleExploreMapClick(ev);
        });

        /*map{{ $model->id }}.on('click', function(ev) {
            let position = ev.latlng;
            //console.log('Click', 'lat', position.lat, 'lng', position.lng);
            // AJAX request
            //console.log('do', "$('#marker-latitude').val(" + position.lat.toFixed(3) + ");");
            $('#marker-latitude').val(position.lat.toFixed(3));
            $('#marker-longitude').val(position.lng.toFixed(3));
            $('#marker-modal').modal('show');
        });*/

        window.map = map{{ $model->id }};

    </script>
@endsection

@section('modals')
    @parent
    <!-- Deletion forms -->
    @foreach ($model->markers as $marker)
        {!! Form::open(['method' => 'DELETE', 'route' => ['maps.map_markers.destroy', $campaign, $model, $marker], 'style ' => 'display:inline', 'id' => 'delete-form-marker-' . $marker->id]) !!}
        {!! Form::close() !!}
    @endforeach
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    @vite('resources/sass/map-v3.scss')

    <style>
        @foreach ($model->markers as $marker)
        .marker-{{ $marker->id }} {
            @if (!empty($marker->font_colour))color: {{ $marker->font_colour }};
            @endif
        }

        @if ($marker->entity && $marker->icon == 4).marker-{{ $marker->id }} .marker-pin::after {
            background-image: url('{{ $marker->entity->child->thumbnail(400) }}');
            @if (!empty($marker->pin_size))width: {{ $marker->pinSize(false) - 4 }}px;
            height: {{ $marker->pinSize(false) - 4 }}px;
            margin: 2px 0 0 -{{ ceil(($marker->pinSize(false) - 4) / 2) }}px;
            @endif
        }

        @endif
        @if (!empty($marker->pin_size)).marker-{{ $marker->id }} .marker-pin {
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

@section('modals')
    @parent
    {!! Form::open([
        'route' => ['maps.map_markers.store', $campaign, $model],
        'method' => 'POST',
        //'enctype' => 'multipart/form-data',
        //'id' => 'map-marker-new-form'
        'class' => 'ajax-subform',
        'data-maintenance' => 1
    ]) !!}
    <div class="modal fade" id="marker-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content bg-base-100">
                <div class="modal-header">
                    <x-dialog.close :modal="true" />
                    <h4>
                        {{ __('maps/markers.create.title', ['name' => $model->name]) }}
                    </h4>
                </div>
                <div class="modal-body">
                    @include('maps.markers._form', ['model' => null, 'map' => $model, 'activeTab' => 1, 'dropdownParent' => '#marker-modal', 'from' => base64_encode('maps.map_markers.index:' . $model->id)])

                    <x-dialog.footer id="marker-footer">
                        @include('maps.markers._actions')
                    </x-dialog.footer>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@endif
