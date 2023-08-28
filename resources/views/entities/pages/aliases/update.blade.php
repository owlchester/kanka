<?php /** @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/aliases.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_assets.index', [$campaign, $entity->id]), 'label' => __('crud.tabs.assets')],
    ],
    'centered' => true,
])

@section('content')
    {!! Form::model($entityAsset, ['route' => ['entities.entity_assets.update', $campaign, $entity->id, $entityAsset], 'method' => 'PATCH', 'data-shortcut' => 1, 'class' => 'ajax-subform']) !!}

    @include('partials.forms.form', [
        'title' => $entityAsset->name,
        'content' => 'entities.pages.aliases._form',
        'deleteID' => '#delete-alias-' . $entityAsset->id,
        'dialog' => true,
    ])

    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_assets.destroy', $campaign, 'entity' => $entity, 'entity_asset' => $entityAsset], 'style' => 'display:inline', 'id' => 'delete-alias-' . $entityAsset->id]) !!}
    {!! Form::close() !!}
@endsection
