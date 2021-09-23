@extends('layouts.app', [
    'title' => trans('organisations.organisations.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('organisations._menu', ['active' => 'organisations'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('organisations.panels.organisations')
        </div>
    </div>
@endsection
