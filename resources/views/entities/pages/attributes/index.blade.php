<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . (request()->ajax() || request()->filled('dashboard') ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-attributes'
])
@inject('campaignService', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('attribute', [$entity->child, 'add'])
        <div class="header-buttons inline-block flex gap-2 items-center justify-end flex-wrap">

            <a href="https://docs.kanka.io/en/latest/features/attributes.html" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
            </a>
            <a class="btn2 btn-sm" href="{{ route('entities.attributes.template', $entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.attributes.template', $entity) }}">
                <i class="fa-solid fa-copy" aria-hidden="true"></i>
                {{ __('entities/attributes.actions.apply_template') }}
            </a>

            <a href="{{ route('entities.attributes.edit', ['entity' => $entity]) }}" class="btn2 btn-sm btn-accent">
                <i class="fa-solid fa-list" aria-hidden="true"></i>
                {{ __('entities/attributes.actions.manage') }}
            </a>
        </div>
    @endcan
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
                __('crud.tabs.attributes')
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'attributes',
            'model' => $entity->child,
        ])

        <div class="entity-main-block">
            <x-box css="box-entity-attributes">
                @include('entities.pages.attributes.render')
            </x-box>
        </div>

        <input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', $entity) }}" />
    </div>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
@endsection

@section('modals')
    @parent
    <div class="modal fade" id="live-attribute-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100"></div>
        </div>
    </div>
@endsection
