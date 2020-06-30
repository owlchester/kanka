<?php
/**
 * @var \App\Models\MapMarker $marker
 * @var \App\Models\Map $model
 */
?>
@if (!isset($model) || empty($model->image))
    <div class="alert alert-warning">
        <p>{{ __('maps.helpers.missing_image') }}</p>
    </div>
@else
    <p class="help-block">
        {{ __('maps/markers.helper') }}
    </p>

    <div class="map" id="map" style="width: 100%; height: 100%;"></div>

    <div id="map-source"
         data-image="{{ Img::url($model->image) }}"
         data-width="{{ $model->width }}"
         data-height="{{ $model->height }}"
         data-new="{{ route('maps.map_markers.create', [$model]) }}"
    ></div>


@section('scripts')
    @parent
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="//unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>
    <script src="{{ mix('js/location/map-v3.js') }}" defer></script>
    <script src="/vendor/spectrum/spectrum.js" defer></script>

    <script type="text/javascript">
        var bounds = [[0, 0], [{{ $model->height }}, {{ $model->width }}]];
        var baseLayer = L.imageOverlay('{{ Img::url($model->image) }}', bounds);

@foreach ($model->layers as $layer)
        var layer{{ $layer->id }} = L.imageOverlay('{{ Img::url($layer->image) }}', bounds);
@endforeach
        var baseMaps = {
@foreach ($model->layers as $layer)
            "{{ $layer->name }}": layer{{ $layer->id }},
@endforeach
            "Base": baseLayer
        }

        var map = L.map('map', {
            crs: L.CRS.Simple,
            center: [{{ floor($model->height / 2)  }}, {{ floor($model->width / 2) }}],
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

        var markers = {};
@foreach ($model->markers as $marker)
        var marker{{ $marker->id }} = {!! $marker->marker() !!}.addTo(map);
@endforeach

        map.on('click', function(ev) {
            let position = ev.latlng;
            // AJAX request
            $('#marker-latitude').val(Math.ceil(position.lat));
            $('#marker-longitude').val(Math.ceil(position.lng));
            $('#marker-modal').modal('show');
        });

        map.on('click', function(ev) {
            let position = ev.latlng;
            console.log('Click', 'lat', Math.floor(position.lat), 'lng', Math.floor(position.lng));
            // AJAX request
            $('#marker-latitude').val(Math.floor(position.lat));
            $('#marker-longitude').val(Math.floor(position.lng));
            $('#marker-modal').modal('show');
        });

        window.map = map;
    </script>
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="//unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <link href="{{ mix('css/map-v3.css') }}" rel="stylesheet">
    <link href="/vendor/spectrum/spectrum.css" rel="stylesheet">


    <style>
@foreach ($model->markers as $marker)
        .marker-{{ $marker->id }}  {
            background-color: {{ $marker->colour }};
@if ($marker->entity)
            /* entity {{ $marker->entity_id }} */
            background-image: url({{ $marker->entity->child->getImageUrl(400) }});
@endif
        }
@endforeach
    </style>
@endsection

@section('modals')
    <div class="modal fade" id="marker-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                        <h4>
                            {{ __('maps/markers.create.title', ['name' => $model->name]) }}
                        </h4>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['route' => ['maps.map_markers.store', $model],
                            'method' => 'POST',
                            'data-shortcut' => 1,
                            'enctype' => 'multipart/form-data'
                           ]) !!}
                        @include('maps.markers._form', ['model' => null])

                        <div class="form-group">
                            <button class="btn btn-success">{{ trans('crud.save') }}</button>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@endif


