@extends('layouts.app', [
    'title' => trans('characters.organisations.title', ['name' => $model->name]),
    'description' => trans('characters.organisations.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => __('characters.index.title')],
        ['url' => route('characters.show', $model), 'label' => $model->name],
        trans('characters.show.tabs.organisations')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('characters._menu', ['active' => 'organisations'])
        </div>
        <div class="col-md-9">
            @include('characters.panels.organisations')
        </div>
    </div>
@endsection
