<?php /** @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/files.update.title', ['entity' => $entity->name, 'file' => $entityAsset->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_assets.index', [$campaign, $entity]), 'label' => __('crud.tabs.assets')],
    ]
])

@section('content')
    {!! Form::model($entityAsset, ['route' => ['entities.entity_assets.update', $campaign, $entity->id, $entityAsset], 'method' => 'PATCH', 'data-shortcut' => 1, 'class' => 'ajax-subform']) !!}

    @include('partials.forms.form', [
        'title' => $entityAsset->name,
        'content' => 'entities.pages.files._form',
        'deleteID' => '#delete-file-' . $entityAsset->id,
        'dialog' => true,
    ])

    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_assets.destroy', $campaign, 'entity' => $entity, 'entity_asset' => $entityAsset], 'style' => 'display:inline', 'id' => 'delete-file-' . $entityAsset->id]) !!}
    {!! Form::close() !!}
@endsection
