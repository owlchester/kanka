<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapLayer $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/layers.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('maps'), 'label' => \App\Facades\Module::plural(config('entities.ids.map'), __('entities.maps'))],
        ['url' => $map->entity->url(), 'label' => $map->name],
        ['url' => route('maps.map_layers.index', [$campaign, $map]), 'label' => __('maps.panels.layers')],
        __('maps/layers.edit.title', ['name' => $model->name])
        ]
])

@section('content')
    {!! Form::model($model, ['route' => ['maps.map_layers.update', $campaign, 'map' => $map, 'map_layer' => $model], 'method' => 'PATCH', 'id' => 'map-layer-form', 'enctype' => 'multipart/form-data', 'data-maintenance' => 1]) !!}

    <x-box>
        @include('partials.errors')

        @include('maps.layers._form')

        <x-box.footer>
            @include('maps.groups._actions')

            <div class="">
                @include('partials.footer_cancel')
            </div>
        </x-box.footer>
    </x-box>

    {!! Form::close() !!}
@endsection
