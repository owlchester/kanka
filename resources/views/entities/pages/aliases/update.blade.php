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
    <x-form :action="['entities.entity_assets.update', $campaign, $entity->id, $entityAsset]" method="PATCH">
        @include('partials.forms.form', [
            'title' => $entityAsset->name,
            'content' => 'entities.pages.aliases._form',
            'deleteID' => '#delete-alias-' . $entityAsset->id,
            'dialog' => true,
        ])
    </x-form>

    <x-form method="DELETE" :action="['entities.entity_assets.destroy', $campaign, 'entity' => $entity, 'entity_asset' => $entityAsset]" id="delete-alias-{{ $entityAsset->id }}" />
@endsection
