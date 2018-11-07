@extends('layouts.app', [
    'title' => trans('locations.quests.title', ['name' => $model->name]),
    'description' => trans('locations.quests.description'),
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => __('locations.index.title')],
        ['url' => route('locations.show', $model), 'label' => $model->name],
        trans('locations.show.tabs.quests')
    ]
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('locations._menu', ['active' => 'quests'])
        </div>
        <div class="col-md-9">
            @include('locations.panels.quests')
        </div>
    </div>
@endsection
