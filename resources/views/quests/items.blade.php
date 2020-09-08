@extends('layouts.app', [
    'title' => trans('quests.items.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('quests'), 'label' => __('quests.index.title')],
        ['url' => route('quests.show', $model), 'label' => $model->name],
        trans('quests.show.tabs.items')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('quests._menu', ['active' => 'items'])
        </div>
        <div class="col-md-9">
            @include('quests.panels.items')
        </div>
    </div>
@endsection
