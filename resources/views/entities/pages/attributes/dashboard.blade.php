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
        <div class="box box-solid box-entity-attributes">
            <div class="box-body">
                @include('entities.pages.attributes.render')
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
@endsection

