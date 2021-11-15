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


@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header_grid', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('abilities'), 'label' => __('abilities.index.title')],
                __('abilities.show.tabs.entities')
            ]
        ])

        @include('abilities._menu', ['active' => 'entities'])

        <div class="entity-main-block">
            @include('abilities.panels.entities')
        </div>
    </div>
@endsection
