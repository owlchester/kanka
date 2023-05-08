<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityMention $mention */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/mentions.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-mentions'
])

@inject('campaignService', 'App\Services\CampaignService')

@section('entity-header-actions')
        <div class="header-buttons inline-block pull-right ml-auto">
            <button class="btn btn-sm btn-default" data-toggle="dialog"
                    data-target="dialog-help">
                <x-icon class="question"></x-icon>
                {{ __('campaigns.members.actions.help') }}
            </button>
        </div>
@endsection

@section('content')
    @include('partials.errors')
    @include('partials.ads.top')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => \App\Facades\Module::plural($entity->typeId(), __('entities.' . $entity->pluralType()))],
                __('crud.tabs.mentions')
            ]
        ])

        @include($entity->pluralType() . '._menu', [
            'active' => 'mentions',
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">
            @include('entities.pages.mentions.render')
        </div>
    </div>
@endsection


@section('modals')
    <x-dialog id="dialog-help" :title="__('crud.tabs.mentions')">
        <p class="">
            {{ __('entities/mentions.helper') }}
        </p>
    </x-dialog>
@endsection
