<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Ability $ability */?>
@extends('layouts.app', [
    'title' => trans('entities/abilities.show.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.abilities')
    ],
    'mainTitle' => false,
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include($entity->pluralType() . '._menu', ['active' => 'abilities', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-9">
            <div class="box box-solid">
                <div class="box-body" id="abilities">
                    <h2 class="page-header with-border">
                        {{ trans('crud.tabs.abilities') }}
                    </h2>

                    <p class="help-block">{{ __('entities/abilities.show.helper') }}</p>

                    <abilities
                        id="{{ $entity->id }}"
                        api="{{ route('entities.entity_abilities.api', $entity) }}"
                    ></abilities>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
    @parent
    <link href="{{ mix('css/abilities.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/abilities.js') }}" defer></script>
@endsection
