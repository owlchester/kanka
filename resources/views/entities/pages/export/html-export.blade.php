<?php /** @var \App\Models\MiscModel $model */?>

@inject('campaign', 'App\Services\CampaignService')
@php
    $headerImage = true;
@endphp

@extends('layouts.print', [
    'title' => __($name . '.show.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'miscModel' => $model,
    'canonical' => true,
    'mainTitle' => false,
    'bodyClass' => 'entity-story'
])



@include('entities.components.header', ['model' => $model])


@section('content')

    <button class="btn btn-lg btn-warning btn-print" onclick="javascript:window.print();">
        <i class="fas fa-print"></i> {{ __('crud.actions.print') }}
    </button>

    @include($name . '.show')
    @includeIf('entities.pages.profile._' . $name)
    @includeIf($name . '._print')
    @includeWhen($entity->abilities->count() > 0, 'entities.pages.abilities._abilities')
    @includeWhen($entity->inventories->count() > 0, 'entities.pages.inventory._inventory', [
    'inventory' =>
            $entity->inventories()
            ->with(['entity', 'item', 'item.entity'])
            ->has('entity')
            ->get()
            ->sortBy(function($model, $key) {
                return !empty($model->position) ? $model->position : 'zzzz' . $model->itemName();
            })
])
    @includeWhen($entity->relationships->count() > 0, 'entities.pages.relations._table', [
    'relations' => $entity
        ->allRelationships()
        ->get(),
     'mode' => 'table'
])
    @includeWhen($entity->attributes->count() > 0, 'entities.pages.attributes.render', [
    'attributes' => $entity
        ->allRelationships()
        ->get(),
     'mode' => 'table'
])

@endsection



@section('styles')
    @parent
    <link href="{{ mix('css/abilities.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/abilities.js') }}" defer></script>
@endsection
