<?php
/**
 * entities/<id>/permissions
 * @var \App\Models\Entity $entity
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\CampaignUser $member
 */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('crud.permissions.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show($entity),
        __('crud.edit'),
    ]
])

@section('content')
    @inject('permissionService', 'App\Services\PermissionService')
@php
/** @var \App\Services\PermissionService $permissionService */
$permissions = $permissionService->type($entity->type_id)->entityPermissions($entity);
@endphp
    <x-form :action="['entities.permissions', $campaign, $entity->id]" direct>
        @include('partials.forms.form', [
            'title' => __('crud.permissions.title', ['name' => $entity->name]),
            'content' => 'cruds.permissions.permissions_table',
            'dialog' => true,
            'articleClass' => 'max-w-3xl',
            'showPermissionActions' => true
        ])
        <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
    </x-form>
@endsection
