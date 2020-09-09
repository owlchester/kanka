@extends('layouts.app', [
    'title' => trans('races.races.title', ['name' => $model->name]),
    'description' => trans('races.races.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('races'), 'label' => __('races.index.title')],
        ['url' => route('races.show', $model), 'label' => $model->name],
        trans('races.show.tabs.races')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('races._menu', ['active' => 'races'])
        </div>
        <div class="col-md-9">
            @include('races.panels.races')
        </div>
    </div>
@endsection
