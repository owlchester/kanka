<?php /** @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
        'title' => __('entities/files.update.title'),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_assets.index', [$campaign, $entity]), 'label' => __('crud.tabs.assets')],
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['entities.entity_assets.update', $campaign, $entity->id, $entityAsset]" method="PATCH">

    @include('partials.forms.form', [
        'title' => __('entities/files.update.title'),
        'content' => 'entities.pages.files._form',
        'deleteID' => '#delete-file-' . $entityAsset->id,
    ])

    </x-form>

    <x-form method="DELETE" :action="['entities.entity_assets.destroy', $campaign, 'entity' => $entity, 'entity_asset' => $entityAsset]" id="delete-file-{{ $entityAsset->id }}" />
@endsection
