<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.app', [
    'title' => __('entities/links.show.title', ['name' => $entity->name]),
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
        <div class="box-body text-center ">
            {{ __('entities/links.helpers.leaving') }}

            <div class="margin-top">
                <a href="{{ $entityAsset->metadata['url'] }}" rel="noreferrer nofollow" class="btn btn-lg btn-primary">
                    {{ __('entities/links.helpers.goto', ['name' => $entityAsset->name]) }}
                </a>
            </div>
        </div>
        <div class="box-footer text-center">
            <p class="help-block">{{ __('entities/links.helpers.url', ['url' => $entityAsset->metadata['url']]) }}</p>
        </div>

    </div>
    </section>
@endsection
