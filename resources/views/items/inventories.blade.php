@extends('layouts.app', [
    'title' => trans('items.inventories.title', ['name' => $model->name]),
    'description' => trans('items.inventories.description'),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('items._menu', ['active' => 'inventories'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('items.panels.inventories')
        </div>
    </div>
@endsection
