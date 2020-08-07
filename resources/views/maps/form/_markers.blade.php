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
        <a href="{{ route('maps.explore', $model) }}" target="_blank" class="btn btn-primary btn-map-explore"><i class="fa fa-map"></i> {{ __('maps.actions.explore') }}</a>
    </div>

@section('scripts')
    @parent
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="//unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>
    <script src="{{ mix('js/location/map-v3.js') }}" defer></script>
    <script src="/vendor/spectrum/spectrum.js" defer></script>

    <script type="text/javascript">

        var markers = {};
@foreach ($model->markers as $marker)
        var marker{{ $marker->id }} = {!! $marker->marker() !!};
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
            console.log('Click', 'lat', position.lat, 'lng', position.lng);
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
        {!! Form::open(['method' => 'DELETE', 'route' => ['maps.map_markers.destroy', $model, $marker], 'style '=> 'display:inline', 'id' => 'delete-form-marker-' . $marker->id]) !!}
        {!! Form::close() !!}
    @endforeach
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
            background-color: {{ $marker->backgroundColour() }};
@if ($marker->entity && $marker->icon == 4)
            /* entity {{ $marker->entity_id }} */
            background-image: url({{ $marker->entity->child->getImageUrl(400) }});
@endif
        }
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
                        @include('maps.markers._form', ['model' => null, 'map' => $model])

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


