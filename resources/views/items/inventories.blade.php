@extends('layouts.app', [
    'title' => trans('items.inventories.title', ['name' => $model->name]),
    'description' => trans('items.inventories.description'),
    'breadcrumbs' => [
        ['url' => route('items.show', $model), 'label' => $model->name],
        trans('items.show.tabs.inventories')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include('items._menu', ['active' => 'inventories'])
        </div>
        <div class="col-md-10">
            @include('items.panels.inventories')
        </div>
    </div>
@endsection
