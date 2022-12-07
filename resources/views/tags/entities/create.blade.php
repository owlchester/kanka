<?php /** @var \App\Models\Tag $model */ ?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('tags.children.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('tags'), 'label' => trans('entities.tags')],
        ['url' => route('tags.show', $model->id), 'label' => $model->name]
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
