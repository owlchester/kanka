<?php /** @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/aliases.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_assets.index', $entity->id), 'label' => __('crud.tabs.assets')],
    ]
])

@section('content')
    {!! Form::model($entityAsset, ['route' => ['entities.entity_assets.update', $entity->id, $entityAsset], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}

    @include('partials.forms.form', [
        'title' => $entityAsset->name,
        'content' => 'entities.pages.aliases._form',
        'deleteID' => '#delete-alias-' . $entityAsset->id
    ])

    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_assets.destroy', 'entity' => $entity, 'entity_asset' => $entityAsset], 'style' => 'display:inline', 'id' => 'delete-alias-' . $entityAsset->id]) !!}
    {!! Form::close() !!}
@endsection
