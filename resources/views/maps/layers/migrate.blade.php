<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapLayer $layer
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/layers.migrate.title', ['name' => $layer->name]),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($map->entity)->list(),
        Breadcrumb::show(),
        ['url' => route('maps.map_layers.index', [$campaign, $map]), 'label' => __('maps.panels.layers')],
        __('maps/layers.edit.title', ['name' => $layer->name])
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['maps.layers.migrate', $campaign, 'map' => $map, 'map_layer' => $layer]">
    <x-box>
        @include('partials.errors')

        <x-alert type="warning">
            <p>This layer's image needs to be migrated to the <a href="{{ route('gallery', $campaign) }}">campaign gallery</a> before it can be edited.</p>
        </x-alert>

        <x-box.footer>
            <div class="flex gap-2">
                <div class="grow">
                    @include('partials.footer_cancel')
                </div>
                <button type="submit" class="btn2 btn-primary">
                    Migrate
                </button>
            </div>

        </x-box.footer>
    </x-box>

    </x-form>
@endsection
