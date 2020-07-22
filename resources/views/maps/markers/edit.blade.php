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
            <div class="map map-form" id="map" style="width: 100%; height: 100%;"></div>
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
    <script src="//unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>
    <script src="{{ mix('js/location/map-v3.js') }}" defer></script>
    <script src="/vendor/spectrum/spectrum.js" defer></script>

    @include('maps._setup')
    <script type="text/javascript">
        var marker{{ $model->id }} = {!! $model->editing()->marker() !!}.addTo(map);
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
        .marker-{{ $model->id }}  {
            background-color: {{ $model->colour ?? 'unset' }};
        @if ($model->entity && $model->icon == 4)
            background-image: url({{ $model->entity->child->getImageUrl(400) }});
        @endif
    }
    </style>
@endsection
