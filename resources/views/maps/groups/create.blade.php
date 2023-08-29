<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapGroup $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/groups.create.title', ['name' => $map->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($map->entity)->list(),
        Breadcrumb::show($map),
        ['url' => route('maps.map_groups.index', [$campaign, $map]), 'label' => __('maps.panels.groups')],
        __('maps/groups.create.title')
    ],
    'centered' => true,
])

@section('content')

    {!! Form::open(['route' => ['maps.map_groups.store', $campaign, $map], 'method' => 'POST', 'data-shortcut' => 1, 'data-maintenance' => 1]) !!}

    @include('partials.forms.form', [
        'title' => __('maps/groups.create.title', ['name' => $map->name]),
        'content' => 'maps.groups._form',
        'formParams' => ['model' => null, 'map' => $map],
        'actions' => 'maps.groups._actions'
    ])

    {!! Form::close() !!}
@endsection
