@extends('layouts.app', [
    'title' => trans('families.members.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('families'), 'label' => __('families.index.title')],
        ['url' => route('families.show', $model), 'label' => $model->name],
        trans('families.show.tabs.members')
    ],
    'mainTitle' => false,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('families._menu', ['active' => 'all_members'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('families.panels.all_members')
        </div>
    </div>
@endsection
