<?php /** @var \App\Models\Entity $entity */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/tags.create.title', ['name' => $entity->name]),
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
            'title' => __('entities/tags.create.title', ['name' => $entity->name]),
            'content' => 'entities.pages.tags._form',
            'submit' =>  __('crud.save'),
        ])
        <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
    </x-form>
@endsection
