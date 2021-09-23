@extends('layouts.app', [
    'title' => trans('families.families.title', ['name' => $model->name]),
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
            @include('families._menu', ['active' => 'families'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('families.panels.families')
        </div>
    </div>
@endsection
