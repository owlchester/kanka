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
    <x-form :action="$formOptions">
        @include('partials.forms.form', [
            'title' => __('tags.children.create.entity', ['name' => $model->name]),
            'content' => 'entities.components.tags._form',
            'submit' =>  __('tags.children.actions.add_entity'),
            'dialog' => true,
        ])
        <input type="hidden" name="entity_id" value="{{ $model->entity->id }}" />
    </x-form>
@endsection
