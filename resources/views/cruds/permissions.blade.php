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
        Breadcrumb::show($entity->child),
        __('crud.edit'),
    ]
])

@section('content')
    @inject('permissionService', 'App\Services\PermissionService')
@php
/** @var \App\Services\PermissionService $permissionService */
$permissions = $permissionService->type($entity->type_id)->entityPermissions($entity);
@endphp
    {!! Form::open(['route' => ['entities.permissions', $campaign, $entity->id], 'method'=>'POST', 'data-shortcut' => '1']) !!}

    @include('partials.forms.form', [
        'title' => __('crud.permissions.title', ['name' => $entity->name]),
        'content' => 'cruds.permissions.permissions_table',
        'dialog' => true,
    ])
    {!! Form::hidden('entity_id', $entity->id) !!}
    {!! Form::close() !!}
@endsection
