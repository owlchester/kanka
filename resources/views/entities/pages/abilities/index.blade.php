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
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ trans('crud.tabs.abilities') }}
                    </h2>

                    <p class="help-block">
                        @can('update', $entity->child)
                            <a href="{{ route('entities.entity_abilities.create', $entity) }}" class="btn btn-primary pull-right"
                               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_abilities.create', $entity) }}">
                                <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('entities/abilities.actions.add') }}</span>
                            </a>
                        @endcan
                        {{ __('entities/abilities.show.helper') }}
                    </p>

                </div>
            </div>

            <div  id="abilities">
                <abilities
                    id="{{ $entity->id }}"
                    api="{{ route('entities.entity_abilities.api', $entity) }}"
                    permission="{{ Auth::check() && Auth::user()->can('update', $entity->child) }}"
                ></abilities>
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
