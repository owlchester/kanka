<?php /** @var \App\Models\Ability $model */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('abilities.children.create.modal', ['name' => $model->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model),
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="$formOptions">
        @include('partials.forms._dialog', [
            'title' => __('abilities.children.create.modal', ['name' => $model->name]),
            'content' => 'abilities.entities._form',
        ])
        <input type="hidden" name="ability_id" value="{{ $model->entity->id }}" />
    </x-form>

@endsection
