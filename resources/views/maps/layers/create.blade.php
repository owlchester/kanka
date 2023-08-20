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
        ['url' => Breadcrumb::index('maps'), 'label' => \App\Facades\Module::plural(config('entities.ids.map'), __('entities.maps'))],
        ['url' => $map->entity->url(), 'label' => $map->name],
        ['url' => route('maps.map_layers.index', [$campaign, $map]), 'label' => __('maps.panels.layers')],
        __('maps/layers.create.title')
    ]
])

@section('content')
    {!! Form::open(['route' => ['maps.map_layers.store', $campaign, $map], 'method' => 'POST', 'id' => 'map-layer-form', 'enctype' => 'multipart/form-data', 'data-maintenance' => 1]) !!}

        <x-box>

            @include('partials.errors')

            @include('maps.layers._form', ['model' => null])

            <x-box.footer>
                @include('maps.groups._actions')
                <div class="">
                    @include('partials.footer_cancel')
                </div>
            </x-box.footer>
    </x-box>

    {!! Form::close() !!}
@endsection
