<?php
/**
 * entities/<id>/permissions
 * @var \App\Models\Entity $entity
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/permissions.quick.title'),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.edit'),
    ]
])

@section('content')
    @if ($canEditPermissions)
        <x-form :action="['entities.permissions-process', $campaign, $entity->id]" direct>
            @include('partials.forms._dialog', [
                'title' => __('entities/permissions.quick.title'),
                'content' => 'entities.pages.permissions._share_sheet',
                'articleClass' => 'max-w-2xl',
            ])
            <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
        </x-form>
    @else
        <x-dialog.header>
            {!! __('entities/permissions.quick.title') !!}
        </x-dialog.header>
        <article class="max-w-2xl py-4 px-4 md:px-6">
            @include('entities.pages.permissions._share_sheet')
        </article>
    @endif
@endsection
