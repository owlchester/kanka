<?php /** @var \App\Models\Tag $model */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('tags.children.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model),
    ]
])

@section('content')
    {!! Form::open(['route' => $formOptions, 'method' => 'POST']) !!}

    @include('partials.forms.form', [
        'title' => __('tags.children.create.title', ['name' => $model->name]),
        'content' => 'tags.entities._form',
        'submit' =>  __('tags.children.actions.add')
    ])
    {!! Form::hidden('tag_id', $model->entity->id) !!}
    {!! Form::close() !!}
@endsection
