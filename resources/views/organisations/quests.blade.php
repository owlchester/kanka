@extends('layouts.app', [
    'title' => trans('organisations.quests.title', ['name' => $model->name]),
    'description' => trans('organisations.quests.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('organisations'), 'label' => __('organisations.index.title')],
        ['url' => route('organisations.show', $model), 'label' => $model->name],
        trans('organisations.show.tabs.quests')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('organisations._menu', ['active' => 'quests'])
        </div>
        <div class="col-md-9">
            @include('organisations.panels.quests')
        </div>
    </div>
@endsection
