<?php /** @var \App\Models\Tag $model */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('tags.children.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($model->entity)->list(),
        Breadcrumb::show(),
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="$formOptions">
        @include('partials.forms._dialog', [
            'title' => __('tags.children.create.title', ['name' => $model->name]),
            'content' => 'tags.entities._form',
            'submit' =>  __('tags.children.actions.add'),
        ])
        <input type="hidden" name="tag_id" value="{{ $model->entity->id }}" />
    </x-form>
@endsection
