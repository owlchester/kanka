<?php /** @var \App\Models\Entity $entity */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/image.replace.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('entities/image.replace.breadcrumb')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
    'bodyClass' => 'entity-image-replace'
])


@section('content')
    {!! Form::open([
        'route' => ['entities.image.replace', $campaign, $entity],
        'method' => 'POST',
        'enctype' => 'multipart/form-data',
        'class' => 'ajax-subform',
    ]) !!}
        @include('partials.forms.form', [
            'title' => __('entities/image.replace.title', ['name' => $entity->name]),
            'content' => 'entities.pages.image._form',
            'submit' => __('entities/image.actions.save-replace'),
            'dialog' => true,
        ])

    {!! Form::close() !!}
@endsection
