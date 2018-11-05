@extends('layouts.app', [
    'title' => trans('quests.locations.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('quests.show', $model), 'label' => $model->name],
        trans('quests.show.tabs.locations')
    ]
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('quests._menu', ['active' => 'locations'])
        </div>
        <div class="col-md-9">
            @include('quests.panels.locations')
        </div>
    </div>
@endsection
