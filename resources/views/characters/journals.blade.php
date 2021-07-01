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

@include('entities.components.header', ['model' => $model])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('characters._menu', ['active' => 'journals'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('characters.panels.journals')
        </div>
    </div>
@endsection
