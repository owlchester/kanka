<?php /** @var \App\Models\QuestElement $element */?>
@extends('layouts.app', [
    'title' => __('quests.elements.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons">

            <a href="{{ route('quests.quest_elements.create', ['quest' => $model->id]) }}" class="btn btn-sm btn-warning">
                <i class="fa-solid fa-plus"></i>
                <span class="hidden-xs hidden-sm">{{ __('quests.show.actions.add_element') }}</span>
            </a>
        </div>
    @endcan
@endsection

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header_grid', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('quests'), 'label' => __('quests.index.title')],
                __('quests.show.tabs.elements')
            ]
        ])

        @include('quests._menu', ['active' => 'elements'])

        <div class="entity-main-block">
            @include('quests.elements._elements')
        </div>
    </div>
@endsection
