<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.app', [
    'title' => __('entities/links.go.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.links')
    ],
    'mainTitle' => false,
    'miscModel' => $entity->child,
])
@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    <section class="content">
    <div class="box box-solid">
        <div class="box-body text-center">
            <h3 class="box-title">{{ __('entities/links.go.title') }}</h3>

            <p>{!! __('entities/links.go.description', ['link' => '<strong>' . $entityAsset->metadata['url'] . '</strong>']) !!}</p>

        </div>
        <div class="box-footer text-center">

            <div class="mb-2">
                <a href="{{ $entity->url('show') }}" class="btn btn-default btn-lg mr-2 px-8">
                    {{ __('crud.cancel') }}
                </a>
                <a href="{{ $entityAsset->metadata['url'] }}" rel="noreferrer nofollow" class="btn btn-lg btn-primary ml-2 px-8">
                    {{ __('entities/links.go.actions.confirm') }}
                </a>
            </div>

            <a href="{{ $entityAsset->metadata['url'] }}" rel="noreferrer nofollow" class="domain-trust" data-domain="{{ $entityAsset->urlDomain() }}">
                {{ __('entities/links.go.actions.trust') }}
            </a>
        </div>

    </div>
    </section>
@endsection
