@extends('layouts.app', [
    'title' => trans('characters.conversations.title', ['name' => $model->name]),
    'description' => trans('characters.conversations.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => __('characters.index.title')],
        ['url' => route('characters.show', $model), 'label' => $model->name],
        trans('characters.show.tabs.conversations')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('characters._menu', ['active' => 'conversations'])
        </div>
        <div class="col-md-9">
            @include('characters.panels.conversations')
        </div>
    </div>
@endsection
