@extends('layouts.app', [
    'title' => trans('organisations.members.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('organisations'), 'label' => __('organisations.index.title')],
        ['url' => route('organisations.show', $model), 'label' => $model->name],
        trans('organisations.fields.members')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('organisations._menu', ['active' => 'members'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('organisations.panels.members')
        </div>
    </div>
@endsection
