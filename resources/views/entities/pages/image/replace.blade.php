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
    'bodyClass' => 'entity-image-replace'
])


@section('content')
    <x-form :action="['entities.image.replace', $campaign, $entity]" files>
        @include('partials.forms.form', [
            'title' => __('entities/image.replace.title', ['name' => $entity->name]),
            'content' => 'entities.pages.image._form',
            'submit' => __('entities/image.actions.save-replace'),
            'dialog' => true,
        ])
    </x-form>
@endsection
