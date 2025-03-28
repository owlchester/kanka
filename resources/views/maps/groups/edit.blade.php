<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapGroup $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/groups.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($map->entity)->list(),
        Breadcrumb::show($map),
        ['url' => route('maps.map_groups.index', [$campaign, $map]), 'label' => __('maps.panels.groups')],
        __('maps/groups.edit.title', ['name' => $model->name])
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['maps.map_groups.update', 'campaign' => $campaign, 'map' => $map, 'map_group' => $model]" method="PATCH" id="map-group-form" files>
        @include('partials.forms._dialog', [
            'title' => __('maps/groups.edit.title', ['name' => $map->name]),
            'content' => 'maps.groups._form',
            'actions' => 'maps.groups._actions',
        ])
    </x-form>
@endsection
