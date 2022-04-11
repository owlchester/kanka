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
        {{ __('maps/markers.helpers.base') }}
    </p>

    <div class="map" id="map{{ $model->id }}" style="width: 100%; height: 100%;">
        <a href="{{ route('maps.explore', $model) }}" target="_blank" class="btn btn-primary btn-map-explore"><i
                class="fa fa-map"></i> {{ __('maps.actions.explore') }}</a>
    </div>


    <div class="map-legend">
        @include('maps.explore.legend', ['map' => $model])
    </div>

    @section('scripts')
        @parent
        <!-- Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
        <script src="{{ mix('js/ajax-subforms.js') }}" defer></script>
        <script src="{{ mix('js/location/map-v3.js') }}" defer></script>

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
        @include('maps._setup', ['map' => $model])
        <script type="text/javascript">
            @foreach ($model->markers as $marker)
                @if (empty($marker->group_id))
                    marker{{ $marker->id }}.addTo(map{{ $model->id }});
                @endif
            @endforeach

            map{{ $model->id }}.on('click', function(ev) {
                let position = ev.latlng;
                //console.log('Click', 'lat', position.lat, 'lng', position.lng);
                // AJAX request
                //console.log('do', "$('#marker-latitude').val(" + position.lat.toFixed(3) + ");");
                $('#marker-latitude').val(position.lat.toFixed(3));
                $('#marker-longitude').val(position.lng.toFixed(3));
                $('#marker-modal').modal('show');
            });

            window.map = map{{ $model->id }};

        </script>
    @endsection

    @section('modals')
        @parent
        <!-- Deletion forms -->
        @foreach ($model->markers as $marker)
            {!! Form::open(['method' => 'DELETE', 'route' => ['maps.map_markers.destroy', $model, $marker], 'style ' => 'display:inline', 'id' => 'delete-form-marker-' . $marker->id]) !!}
            {!! Form::close() !!}
        @endforeach
    @endsection

    @section('styles')
        @parent
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
            integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
            crossorigin="" />
        <link href="{{ mix('css/map-v3.css') }}" rel="stylesheet">

        <style>
            @foreach ($model->markers as $marker)
            .marker-{{ $marker->id }} {
                @if (!empty($marker->font_colour))color: {{ $marker->font_colour }};
                @endif
            }

            @if ($marker->entity && $marker->icon == 4).marker-{{ $marker->id }} .marker-pin::after {
                background-image: url('{{ $marker->entity->child->getImageUrl(400) }}');
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
    <div class="modal fade" id="marker-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ trans('crud.delete_modal.close') }}"><span
                                aria-hidden="true">&times;</span></button>
                        <h4>
                            {{ __('maps/markers.create.title', ['name' => $model->name]) }}
                        </h4>
                    </div>
                    <div class="panel-body">

                        {!! Form::open([
    'route' => ['maps.map_markers.store', $model],
    'method' => 'POST',
    //'enctype' => 'multipart/form-data',
    //'id' => 'map-marker-new-form'
    'class' => 'ajax-subform',
]) !!}
                        @include('maps.markers._form', ['model' => null, 'map' => $model, 'activeTab' => 1, 'dropdownParent' => '#marker-modal'])

                        <div class="form-group">
                            <div class="submit-group">
                                <button class="btn btn-success">{{ __('crud.save') }}</button>
                            </div>
                            <div class="submit-animation" style="display: none;">
                                <button class="btn btn-success" disabled><i class="fa fa-spinner fa-spin"></i></button>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@endif
