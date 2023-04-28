<?php /** @var \App\Models\QuestElement $element */?>
@extends('layouts.app', [
    'title' => $model->name . ' - ' . __('quests.show.tabs.elements'),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons inline-block pull-right ml-auto">

            <a href="{{ route('quests.quest_elements.create', ['quest' => $model->id]) }}" class="btn btn-sm btn-warning">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                <span class="hidden-xs hidden-sm">{{ __('quests.show.actions.add_element') }}</span>
            </a>
        </div>
    @endcan
@endsection

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('quests'), 'label' => \App\Facades\Module::plural(config('entities.ids.quest'), __('entities.quests'))],
                __('quests.show.tabs.elements')
            ]
        ])

        @include('quests._menu', ['active' => 'elements'])

        <div class="entity-main-block">
            @include('quests.elements._elements')
        </div>
    </div>
@endsection
