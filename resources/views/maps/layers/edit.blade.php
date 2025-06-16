<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapLayer $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/layers.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($map->entity)->list(),
        Breadcrumb::show(),
        ['url' => route('maps.map_layers.index', [$campaign, $map]), 'label' => __('maps.panels.layers')],
        __('maps/layers.edit.title', ['name' => $model->name])
    ],
    'centered' => true,
])

@section('content')
    @include('partials.errors')
    <x-form :action="['maps.map_layers.update', $campaign, 'map' => $map, 'map_layer' => $model]" method="PATCH" id="map-layer-form" files>
        <x-box>
            @include('maps.layers._form')

            <div class="flex justify-between gap-2 mt-4">
                <div>
                    @include('partials.footer_cancel')
                </div>
                @include('maps.groups._actions')
            </div>
        </x-box>

    </x-form>
@endsection
