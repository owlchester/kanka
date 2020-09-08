@extends('layouts.app', [
    'title' => trans('items.quests.title', ['name' => $model->name]),
    'description' => trans('items.quests.description'),
    'breadcrumbs' => [
        ['url' => route('items.show', $model), 'label' => $model->name],
        trans('items.show.tabs.quests')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('items._menu', ['active' => 'quests'])
        </div>
        <div class="col-md-9">
            @include('items.panels.quests')
        </div>
    </div>
@endsection
