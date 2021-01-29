@extends('layouts.app', [
    'title' => __('timelines.timelines.title', ['name' => $model->name]),
    'description' => __('timelines.timelines.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('timelines'), 'label' => __('timelines.index.title')],
        ['url' => route('timelines.show', $model), 'label' => $model->name],
        __('timelines.fields.timelines')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('timelines._menu', ['active' => 'timelines'])
        </div>
        <div class="col-md-9">
            @include('timelines.panels.timelines')
        </div>
    </div>
@endsection
