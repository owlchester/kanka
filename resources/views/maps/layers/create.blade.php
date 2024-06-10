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
    <x-form :action="['maps.map_layers.store', $campaign, $map]" files id="map-layer-form">
        <x-box>
            @include('partials.errors')

            @include('maps.layers._form', ['model' => null])

            <x-box.footer>
                <div class="flex gap-2">
                    <div class="grow">
                    @include('partials.footer_cancel')
                    </div>
                    @include('maps.groups._actions')
                </div>
            </x-box.footer>
    </x-box>

    </x-form>
@endsection
