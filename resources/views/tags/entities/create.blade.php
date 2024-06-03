<?php /** @var \App\Models\Tag $model */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('tags.children.create.modal_title', ['name' => $model->name]),
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
        'title' => __('tags.children.create.modal_title', ['name' => $model->name]),
        'content' => 'tags.entities._form',
        'submit' =>  __('tags.children.actions.add'),
        'dialog' => true,
    ])
    <input type="hidden" name="tag_id" value="{{ $model->entity->id }}" />
    {!! Form::close() !!}
@endsection
