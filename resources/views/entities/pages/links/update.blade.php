<?php /** @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/links.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_assets.index', [$campaign, $entity->id]), 'label' => __('crud.tabs.assets')],
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['entities.entity_assets.update', $campaign, $entity, $entityAsset]" method="PATCH">
        @include('partials.forms._dialog', [
    'title' => __('entities/links.update.title', ['name' => $entity->name]),
            'content' => 'entities.pages.links._form',
            'deleteID' => '#delete-link-' . $entityAsset->id,
        ])
    </x-form>

    <x-form method="DELETE" :action="['entities.entity_assets.destroy', $campaign, 'entity' => $entity, 'entity_asset' => $entityAsset]" id="delete-link-{{ $entityAsset->id }}" />
@endsection
