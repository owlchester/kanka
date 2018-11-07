@extends('layouts.app', [
    'title' => trans('quests.characters.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('quests.index'), 'label' => __('quests.index.title')],
        ['url' => route('quests.show', $model), 'label' => $model->name],
        trans('quests.show.tabs.characters')
    ]
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('quests._menu', ['active' => 'characters'])
        </div>
        <div class="col-md-9">
            @include('quests.panels.characters')
        </div>
    </div>
@endsection
