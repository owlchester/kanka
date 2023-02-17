<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapMarker $model
* @var \App\Models\MapMarker $source
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/markers.create.title', ['name' => $map->name]),
    'breadcrumbs' => [
        ['url' => $map->entity->url('index'), 'label' => __('entities.maps')],
        ['url' => $map->entity->url(), 'label' => $map->name],
        __('maps/markers.create.title')
    ]
])


@section('content')
    {!! Form::open(['route' => ['maps.map_markers.store', $campaign, $map], 'method' => 'POST', 'id' => 'map-marker-form', 'class' => 'ajax-subform']) !!}
    <div class="modal-content">
        @if (request()->ajax())
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    {{ __('maps/markers.create.title', ['name' => $map->name]) }}
                </h4>
            </div>
        @endif
        <div class="modal-body">
            @include('partials.errors')

            @if (!request()->ajax())
                <div class="map mb-4" id="map{{ $map->id }}" style="width: 100%; height: 100%;"></div>
            @endif

            @include('maps.markers._form', ['model' => null])

        </div>
        <div class="modal-footer">

            <div class="pull-left">
                @include('partials.footer_cancel', ['ajax' => null])
            </div>
            @include('maps.markers._actions')
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    @parent
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="{{ mix('js/ajax-subforms.js') }}" defer></script>
    <script src="{{ mix('js/location/map-v3.js') }}" defer></script>

    @if (!request()->ajax() && !empty($source))
        @include('maps._setup', ['single' => true, 'model' => $source])
        <script type="text/javascript">
            var labelShapeIcon = new L.Icon({
                iconUrl: '/images/transparent.png',
                iconSize: [150, 35],
                iconAnchor: [75, 15],
                popupAnchor: [0, -20],
            });

            var marker{{ $source->id }} = {!! $source->editing()->marker() !!}.addTo(map{{ $map->id }});

            window.map = map{{ $map->id }};

        </script>
    @endif
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="{{ mix('css/map-v3.css') }}" rel="stylesheet">
@endsection
