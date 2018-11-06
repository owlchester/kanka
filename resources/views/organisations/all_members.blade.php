@extends('layouts.app', [
    'title' => trans('organisations.members.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('organisations.show', $model), 'label' => $model->name],
        trans('organisations.show.tabs.members')
    ]
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('organisations._menu', ['active' => 'all_members'])
        </div>
        <div class="col-md-9">
            @include('organisations.panels.all_members')
        </div>
    </div>
@endsection
