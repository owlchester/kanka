<?php /** @var \App\Models\Ability $model */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('abilities.children.create.title', ['name' => $model->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model),
    ],
    'centered' => true,
])

@section('content')
    {!! Form::open(['route' => $formOptions, 'method' => 'POST']) !!}
    @include('partials.forms.form', [
        'title' => __('abilities.children.create.title', ['name' => $model->name]),
        'content' => 'abilities.entities._form',
        'dialog' => true,
    ])
    {!! Form::hidden('ability_id', $model->entity->id) !!}
    {!! Form::close() !!}

@endsection
