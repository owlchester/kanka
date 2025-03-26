<?php /** @var \App\Models\Entity $entity */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('tags.children.create.entity', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show($entity),
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="$formOptions">
        @include('partials.forms._dialog', [
            'title' => __('tags.children.create.entity', ['name' => $entity->name]),
            'content' => 'entities.components.tags._form',
            'submit' =>  __('tags.children.actions.add_entity'),
        ])
        <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
    </x-form>
@endsection
