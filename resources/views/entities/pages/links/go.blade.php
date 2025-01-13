<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.app', [
    'title' => __('entities/links.go.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.tabs.links')
    ],
    'mainTitle' => false,
    'miscModel' => $entity->entityType->isSpecial() ? $entity : $entity->child,
    'centered' => true,
])

@section('content')
    <x-box>
        <div class="text-center">
            <h3>{{ __('entities/links.go.title') }}</h3>

            <p>{!! __('entities/links.go.description', ['link' => '<strong>' . $entityAsset->metadata['url'] . '</strong>']) !!}</p>
        </div>
        <div class="flex gap-2 items-center justify-center my-5">
            <a href="{{ $entity->url('show') }}" class="btn2 btn-ghost">
                {{ __('crud.cancel') }}
            </a>
            <a href="{{ $entityAsset->metadata['url'] }}" rel="noreferrer nofollow" class="btn2 btn-primary">
                {{ __('entities/links.go.actions.confirm') }}
            </a>
        </div>
        <div class="text-center">
            <a href="{{ $entityAsset->metadata['url'] }}" rel="noreferrer nofollow" class="domain-trust" data-domain="{{ $entityAsset->urlDomain() }}">
                {{ __('entities/links.go.actions.trust') }}
            </a>
        </div>
    </x-box>
@endsection
