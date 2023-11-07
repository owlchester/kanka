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
    {!! Form::open(['route' => ['maps.map_layers.store', $campaign, $map], 'method' => 'POST', 'id' => 'map-layer-form', 'enctype' => 'multipart/form-data', 'data-maintenance' => 1]) !!}

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

    {!! Form::close() !!}
@endsection
