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

@include('entities.components.header', ['model' => $model])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('characters._menu', ['active' => 'organisations'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('characters.panels.organisations')
        </div>
    </div>
@endsection
