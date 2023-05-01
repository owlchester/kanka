<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapMarker $model
*/
?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('maps/markers.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('maps'), 'label' => \App\Facades\Module::plural(config('entities.ids.map'), __('entities.maps'))],
        ['url' => $map->entity->url(), 'label' => $map->name],
        __('maps/markers.edit.title', ['name' => $model->name])
    ]
])

@inject('campaignService', 'App\Services\CampaignService')
@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('maps/markers.edit.title', ['name' => $model->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            <div class="map mb-4" id="map{{ $map->id }}" style="width: 100%; height: 100%;"></div>
            @include('partials.errors')

            {!! Form::model($model, ['route' => ['maps.map_markers.update', 'map' => $map, 'map_marker' => $model], 'method' => 'PATCH', 'id' => 'map-marker-form', 'class' => 'ajax-subform', 'data-shortcut' => 1, 'data-maintenance' => 1]) !!}
            @include('maps.markers._form')

            <div class="form-group">
                <div class="submit-group">
                    <div class="pull-left">
                        <div class="btn-group">
                            <a role="button" tabindex="-1" class="btn btn-dynamic-delete btn-danger" data-toggle="popover"
                                title="{{ __('crud.delete_modal.title') }}"
                                data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                                 <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-marker-confirm-form-{{ $model->id}}'>{{ __('crud.remove') }}</a>">
                                <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('maps/markers.actions.remove') }}
                            </a>
                        </div>
                    </div>
                    <input id="submit-mode" type="hidden" value="true"/>
                    <div class="pull-right">
                        @include('maps.markers._actions')
                    </div>
                    <div class="pull-right mr-2">
                        @include('partials.footer_cancel', ['ajax' => null])
                    </div>
                </div>
                <div class="submit-animation" style="display: none;">
                    <button class="btn btn-success" disabled><i class="fa-solid fa-spinner fa-spin"></i></button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['maps.map_markers.destroy', $model->map_id, $model->id],
        'style' => 'display:inline',
        'id' => 'delete-marker-confirm-form-' . $model->id]) !!}
    {!! Form::close() !!}


@endsection

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
        'resources/js/ajax-subforms.js'
    ])

    @include('maps._setup', ['single' => true])
    <script type="text/javascript">
        var labelShapeIcon = new L.Icon({
            iconUrl: '/images/transparent.png',
            iconSize: [150, 35],
            iconAnchor: [75, 15],
            popupAnchor: [0, -20],
        });

        var marker{{ $model->id }} = {!! $model->editing()->multiplier($map->is_real)->marker() !!}.addTo(map{{ $map->id }});
        window.polygon = marker{{ $model->id }};
        window.polygon.enableEdit();
        //window.polygon.on('dragend', dragend);
        window.polygon.on('editable:dragend', updateHandler);
        window.polygon.on('editable:vertex:dragend', updateHandler);
        window.polygon.on('editable:vertex:dragend', updateHandler);

        let shape = document.getElementsByName('shape_id');
        /*map{{ $map->id }}.on('click', function(ev) {
            // Only do this is the map is a polygon
            if (!isPolygon()) {
                return;
            }
            window.map.removeLayer(window.polygon);
            let position = ev.latlng;
            let lat = position.lat.toFixed(3);
            let lng = position.lng.toFixed(3);
            window.addPolygonPosition(lat, lng);
        });*/
        map{{ $map->id }}.dragging.enable();

        window.map = map{{ $map->id }};

        function updateHandler(data) {
            if (isPolygon()) {
                updatePolygon(data);
            }
            else if (isLabel()) {
                updateLabel(data);
            }
        }

        const updatePolygon = (data) => {
            //console.log('polygon updated', data);
            let points = data.target.getLatLngs();
            if (points.length === 0) {
                return;
            }

            let coords = [];
            points[0].forEach((i) => {
                coords.push(i.lat.toFixed(3) + ',' + i.lng.toFixed(3));
            });
            window.setPolygonPosition(coords.join(' '));
        }

        const updateLabel = (data) => {
            //console.log('label updated', data);
            let points = data.target._latlng;
            if (!points) {
                return;
            }
            $('#marker-latitude').val(points.lat.toFixed(3));
            $('#marker-longitude').val(points.lng.toFixed(3));
        }

        const isPolygon = () => {
            return shape[0].value === 5;
        }
        const isLabel = () => {
            return shape[0].value === 2;
        }

    </script>
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    @vite('resources/sass/map-v3.scss')

    <style>
        .marker-{{ $model->id }} {
            @if (!empty($model->font_colour))color: {{ $model->font_colour }};
            @endif
        }

        @if ($model->entity && $model->icon == 4).marker-{{ $model->id }} .marker-pin::after {
            background-image: url('{{ $model->entity->child->thumbnail(400) }}');
            @if (!empty($model->pin_size))width: {{ $model->pinSize(false) - 4 }}px;
            height: {{ $model->pinSize(false) - 4 }}px;
            margin: 2px 0 0 -{{ ceil(($model->pinSize(false) - 4) / 2) }}px;
            @endif
        }

        @endif

        @if (!empty($model->pin_size)).marker-{{ $model->id }} .marker-pin {
            width: {{ $model->pinSize() }};
            height: {{ $model->pinSize() }};
            margin: -{{ $model->pinSize(false) / 2 }}px 0 0 -{{ $model->pinSize(false) / 2 }}px;
        }

        .marker-{{ $model->id }} i {
            font-size: {{ $model->pinSize(false) / 2 }}px;
        }

        @endif

    </style>
@endsection
