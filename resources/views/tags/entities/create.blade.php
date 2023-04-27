<?php /** @var \App\Models\Tag $model */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('tags.children.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('tags'), 'label' => \App\Facades\Module::plural(config('entities.ids.tag'), __('entities.tags'))],
        ['url' => $model->getLink(), 'label' => $model->name]
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
