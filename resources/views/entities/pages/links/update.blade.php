<?php /** @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/links.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_assets.index', [$campaign, $entity]), 'label' => __('crud.tabs.assets')],
    ]
])

@section('content')
    {!! Form::model($entityAsset, ['route' => ['entities.entity_assets.update', [$campaign, $entity, $entityAsset]], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}

    @include('partials.forms.form', [
        'title' => $entityAsset->name,
        'content' => 'entities.pages.links._form',
        'deleteID' => '#delete-link-' . $entityAsset->id
    ])

    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_assets.destroy', [$campaign, $entity, $entityAsset]], 'style' => 'display:inline', 'id' => 'delete-link-' . $entityAsset->id]) !!}
    {!! Form::close() !!}
@endsection
