@extends('layouts.app', [
    'title' => __('abilities.entities.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons">
            <a href="{{ route('abilities.entity-add', $model) }}" class="btn btn-warning btn-sm"
               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('abilities.entity-add', $model) }}">
                <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('abilities.children.actions.add') }}</span>
            </a>
        </div>
    @endcan
@endsection

@include('entities.components.header', [
    'model' => $model,
    'entity' => $model->entity,
    'breadcrumb' => [
        ['url' => Breadcrumb::index('abilities'), 'label' => __('abilities.index.title')],
        __('abilities.show.tabs.entities')
    ]
])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('abilities._menu', ['active' => 'entities'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('abilities.panels.entities')
        </div>
    </div>
@endsection
