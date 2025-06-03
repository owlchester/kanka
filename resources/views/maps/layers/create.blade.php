<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapLayer $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/layers.create.title', ['name' => $map->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($map->entity)->list(),
        Breadcrumb::show($map),
        ['url' => route('maps.map_layers.index', [$campaign, $map]), 'label' => __('maps.panels.layers')],
        __('maps/layers.create.title')
    ],
    'centered' => true,
])

@section('content')
    @include('partials.errors')
    <x-form :action="['maps.map_layers.store', $campaign, $map]" files id="map-layer-form">
        <x-box>
            @include('maps.layers._form', ['model' => null])

            <div class="flex justify-between gap-2 mt-4">
                <div class="">
                    @include('partials.footer_cancel')
                </div>
                @include('maps.groups._actions')
            </div>
        </x-box>
    </x-form>
@endsection
