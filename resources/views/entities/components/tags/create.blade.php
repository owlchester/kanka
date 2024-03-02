<?php /** @var \App\Models\MiscModel $model */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('tags.children.create.entity', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model),
    ],
    'centered' => true,
])

@section('content')
    {!! Form::open([
        'route' => $formOptions, 
        'method' => 'POST',
        'data-shortcut' => 1,
        'class' => 'ajax-subform',
    ]) !!}

    @include('partials.forms.form', [
        'title' => __('tags.children.create.entity', ['name' => $model->name]),
        'content' => 'entities.components.tags._form',
        'submit' =>  __('tags.children.actions.add_entity'),
        'dialog' => true,
    ])

    {!! Form::hidden('entity_id', $model->entity->id) !!}
    {!! Form::close() !!}
@endsection
