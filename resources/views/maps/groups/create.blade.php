<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapGroup $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/groups.create.title', ['name' => $map->name]),
    'breadcrumbs' => [
        ['url' => route('maps.index'), 'label' => __('entities.maps')],
        ['url' => $map->entity->url('show'), 'label' => $map->name],
        ['url' => route('maps.map_groups.index', [$map]), 'label' => __('maps.panels.groups')],
        __('maps/groups.create.title')
    ]
])

@section('content')

    {!! Form::open(['route' => ['maps.map_groups.store', $map], 'method' => 'POST', 'data-shortcut' => 1]) !!}

    @include('partials.forms.form', [
        'title' => __('maps/groups.create.title', ['name' => $map->name]),
        'content' => 'maps.groups._form',
        'formParams' => ['model' => null, 'map' => $map],
        'actions' => 'maps.groups._actions'
    ])

    {!! Form::close() !!}
@endsection
