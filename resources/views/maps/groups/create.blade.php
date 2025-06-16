<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapGroup $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/groups.create.title', ['name' => $map->name]),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($map->entity)->list(),
        Breadcrumb::show(),
        ['url' => route('maps.map_groups.index', [$campaign, $map]), 'label' => __('maps.panels.groups')],
        __('maps/groups.create.title')
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['maps.map_groups.store', $campaign, $map]">
        @include('partials.forms._dialog', [
            'title' => __('maps/groups.create.title', ['name' => $map->name]),
            'content' => 'maps.groups._form',
            'formParams' => ['model' => null, 'map' => $map],
            'actions' => 'maps.groups._actions',
        ])
    </x-form>
@endsection
