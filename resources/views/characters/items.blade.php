@extends('layouts.app', [
    'title' => trans('characters.items.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => __('characters.index.title')],
        ['url' => route('characters.show', $model), 'label' => $model->name],
        trans('characters.show.tabs.items')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@include('entities.components.header', ['model' => $model])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include('characters._menu', ['active' => 'items'])
        </div>
        <div class="col-md-10">
            @include('characters.panels.items')
        </div>
    </div>
@endsection
