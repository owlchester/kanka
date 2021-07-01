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
        <button type="button" class="close" data-dismiss="modal"
            aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
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
        'id' => 'map-marker-form',
        'class' => 'ajax-subform',
        'data-shortcut' => 1,
        ]) !!}
        @include('maps.markers._form')

        <div class="form-group">
            <div class="submit-group">
                <div class="btn-group">
                    <button class="btn btn-success" id="form-submit-main"
                        data-unsaved="{{ __('crud.hints.unsaved_changes') }}"
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
                {!! Form::hidden('submit', null) !!}
                @includeWhen(!request()->ajax(), 'partials.or_cancel')
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

        @if($model->shape_id == 5)
            map{{ $map->id }}.on('click', function(ev) {
            let position = ev.latlng;
            //console.log('Click', 'lat', position.lat, 'lng', position.lng);
            let polyCoords = $('textarea[name="custom_shape"]');
            polyCoords.val(polyCoords.val() + ' ' + position.lat.toFixed(3) + ',' + position.lng.toFixed(3));

        });
        @endif

        window.map = map{{ $map->id }};
</script>
@endsection

@section('styles')
@parent
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin="" />
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
            background-image: url('{{ $model->entity->child->getImageUrl(400) }}');
        @if(!empty($model->pin_size))
            width: {{ $model->pinSize(false) - 4 }}px;
            height: {{ $model->pinSize(false) - 4 }}px;
            margin: 2px 0 0 -{{ ceil(($model->pinSize(false)-4)/2) }}px;
        @endif
        }@endif

@if(!empty($model->pin_size))
    .marker-{{ $model->id }} .marker-pin {
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
