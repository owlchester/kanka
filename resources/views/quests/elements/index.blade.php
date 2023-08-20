<?php /** @var \App\Models\QuestElement $element */?>
@extends('layouts.app', [
    'title' => $model->name . ' - ' . __('quests.show.tabs.elements'),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    @include('quests.elements._buttons')
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

        @include('entities.components.menu_v2', ['active' => 'elements'])

        <div class="entity-main-block">
            @include('quests.elements._elements')
        </div>
    </div>
@endsection
