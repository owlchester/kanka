<?php /** @var \App\Models\Ability $model */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('abilities.children.create.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('abilities'), 'label' => __('entities.abilities')],
        ['url' => $model->getLink(), 'label' => $model->name]
    ]
])

@section('content')
    {!! Form::open(['route' => $formOptions, 'method' => 'POST']) !!}
    @include('partials.forms.form', [
            'title' => __('abilities.children.create.title', ['name' => $model->name]),
            'content' => 'abilities.entities._form',
        ])
    {!! Form::hidden('ability_id', $model->entity->id) !!}
    {!! Form::close() !!}

@endsection
