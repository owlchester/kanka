<?php /** @var \App\Models\QuestElement $element */?>
@extends('layouts.app', [
    'title' => trans('quests.elements.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('quests'), 'label' => __('quests.index.title')],
        ['url' => route('quests.show', $model), 'label' => $model->name],
        trans('quests.show.tabs.elements')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('quests._menu', ['active' => 'elements', 'name' => 'quests'])
        </div>
        <div class="col-md-9">
            <div class="alert alert-warning">We are currently migrating quests to a new system. The migration is taking longer than expected so this feature is currently disabled. Check out the <a href="{{ config('discord.url') }}" target="_blank">Discord</a> for more info.</div>


        </div>
    </div>
@endsection
