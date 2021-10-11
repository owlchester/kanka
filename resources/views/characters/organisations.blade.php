@extends('layouts.app', [
    'title' => __('characters.organisations.title', ['name' => $model->name]),
    'description' => __('characters.organisations.description'),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

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
