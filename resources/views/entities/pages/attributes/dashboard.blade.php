<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.widget', [
    'title' => __('entities/attributes.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-attributes'
])
@inject('campaignService', 'App\Services\CampaignService')



@section('content')

    <div class="entity-main-block">
        <x-box css="box-entity-attributes">
            @include('entities.pages.attributes.render')
        </x-box>
    </div>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
@endsection

