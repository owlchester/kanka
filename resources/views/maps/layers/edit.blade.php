<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapLayer $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/layers.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('maps.index'), 'label' => __('entities.maps')],
        ['url' => $map->entity->url('show'), 'label' => $map->name],
        ['url' => route('maps.map_layers.index', [$map]), 'label' => __('maps.panels.layers')],
        __('maps/layers.edit.title', ['name' => $model->name])
        ]
])

@section('content')
    {!! Form::model($model, ['route' => ['maps.map_layers.update', 'map' => $map, 'map_layer' => $model], 'method' => 'PATCH', 'id' => 'map-layer-form', 'enctype' => 'multipart/form-data']) !!}

    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            @include('maps.layers._form')
        </div>

        <div class="panel-footer text-right">
            @include('maps.groups._actions')
            <div class="pull-left">
                @include('partials.footer_cancel')
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
