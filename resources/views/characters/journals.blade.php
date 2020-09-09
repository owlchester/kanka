@extends('layouts.app', [
    'title' => trans('characters.journals.title', ['name' => $model->name]),
    'description' => trans('characters.journals.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => __('characters.index.title')],
        ['url' => route('characters.show', $model), 'label' => $model->name],
        trans('characters.show.tabs.journals')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')
@inject('dateRenderer', 'App\Renderers\DateRenderer')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('characters._menu', ['active' => 'journals'])
        </div>
        <div class="col-md-9">
            @include('characters.panels.journals')
        </div>
    </div>
@endsection
