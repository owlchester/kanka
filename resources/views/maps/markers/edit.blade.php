<?php /**
 * @var \App\Models\Map $map
 * @var \App\Models\MapMarker $model
 */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('maps/markers.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('maps.index'), 'label' => __('maps.index.title')],
        ['url' => $map->entity->url('show'), 'label' => $map->name],
        __('maps/markers.edit.title', ['name' => $model->name])
    ]
])

@inject('campaign', 'App\Services\CampaignService')
@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('maps/markers.edit.title', ['name' => $model->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            <div class="map map-form" id="map{{ $map->id }}" style="width: 100%; height: 100%;"></div>
            @include('partials.errors')

            {!! Form::model($model, ['route' => ['maps.map_markers.update', 'map' => $map, 'map_marker' => $model],
                'method' => 'PATCH',
                'data-shortcut' => 1,
                'id' => 'map-marker-form',
                'enctype' => 'multipart/form-data'
               ]) !!}
            @include('maps.markers._form')

            <div class="form-group">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                @if (!$ajax)
                    {!! __('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                @endif
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
    <script src="{{ mix('js/location/map-v3.js') }}" defer></script>
    <script src="/vendor/spectrum/spectrum.js" defer></script>

    @include('maps._setup', ['single' => true])
    <script type="text/javascript">

        var labelShapeIcon = new L.Icon({
            iconUrl: '/images/transparent.png',
            iconSize: [150, 35],
            iconAnchor: [75, 15],
            popupAnchor: [0, -20],
        });

        var marker{{ $model->id }} = {!! $model->editing()->marker() !!}.addTo(map{{ $map->id }});

        window.map = map{{ $map->id }};
    </script>
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <link href="{{ mix('css/map-v3.css') }}" rel="stylesheet">
    <link href="/vendor/spectrum/spectrum.css" rel="stylesheet">


    <style>
        .marker-{{ $model->id }}  {
@if(!empty($model->font_colour))
            color: {{ $model->font_colour }};
@endif
        }
@if ($model->entity && $model->icon == 4)
        .marker-{{ $model->id }} .marker-pin::after {
            background-image: url({{ $model->entity->child->getImageUrl(400) }});
        }@endif
    </style>
@endsection
