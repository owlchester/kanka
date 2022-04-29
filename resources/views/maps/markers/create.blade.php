<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapMarker $model
* @var \App\Models\MapMarker $source
*/
?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
'title' => __('maps/markers.create.title', ['name' => $map->name]),
'description' => '',
'breadcrumbs' => [
['url' => route('maps.index'), 'label' => __('maps.index.title')],
['url' => $map->entity->url('show'), 'label' => $map->name],
__('maps/markers.create.title')
]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('maps/markers.create.title', ['name' => $map->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            @if (!$ajax)
                <div class="map map-form" id="map{{ $map->id }}" style="width: 100%; height: 100%;"></div>
            @endif

            {!! Form::open(['route' => ['maps.map_markers.store', $map], 'method' => 'POST', 'id' => 'map-marker-form', 'class' => 'ajax-subform']) !!}
            @include('maps.markers._form', ['model' => null])

            <div class="form-group">
                <div class="submit-group">
                    <input id="submit-mode" type="hidden" value="true"/>
                    <div class="btn-group">
                        <button class="btn btn-success" id="form-submit-main"
                            data-target="{{ isset($target) ? $target : null }}">{{ __('crud.save') }}</button>
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                            aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="#" class="dropdown-item form-submit-actions">
                                    {{ __('crud.save') }}
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item form-submit-actions" data-action="submit-update">
                                    {{ __('crud.save_and_update') }}
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item form-submit-actions" data-action="submit-explore">
                                    {{ __('maps/markers.actions.save_and_explore') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    @includeWhen(!request()->ajax(), 'partials.or_cancel')
                </div>
                <div class="submit-animation" style="display: none;">
                    <button class="btn btn-success" disabled><i class="fa fa-spinner fa-spin"></i></button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script src="{{ mix('js/ajax-subforms.js') }}" defer></script>
    <script src="{{ mix('js/location/map-v3.js') }}" defer></script>

    @if (!$ajax && !empty($source))
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <link href="{{ mix('css/map-v3.css') }}" rel="stylesheet">
@endsection
