<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.app', [
    'title' => __('entities/links.go.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        __('entities/assets.actions.link')
    ],
    'mainTitle' => false,
    'centered' => true,
])

@section('content')
    <x-box class="flex flex-col gap-4 items-center align-middle">
        <h1 class="text-2xl">{{ __('entities/links.go.title') }}</h1>

        <p>
            {!! __('entities/links.go.description', ['link' => '<strong>' . $entityAsset->metadata['url'] . '</strong>']) !!}
        </p>
        <div class="flex gap-2 items-center justify-center">
            <a href="{{ $entity->url('show') }}" class="btn2 btn-outline">
                {{ __('crud.cancel') }}
            </a>
            <a href="{{ $entityAsset->metadata['url'] }}" rel="noreferrer nofollow" class="btn2 btn-primary">
                {{ __('entities/links.go.actions.confirm') }}
            </a>
        </div>
        <a href="{{ $entityAsset->metadata['url'] }}" rel="noreferrer nofollow" class="domain-trust text-link" data-domain="{{ $entityAsset->urlDomain() }}">
            {{ __('entities/links.go.actions.trust') }}
        </a>
    </x-box>
@endsection
