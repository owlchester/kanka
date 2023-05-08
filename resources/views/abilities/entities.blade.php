@extends('layouts.app', [
    'title' => $model->name . ' - ' . __('abilities.show.tabs.entities'),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')


@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons inline-block pull-right ml-auto">
            <a href="{{ route('abilities.entity-add', $model) }}" class="btn btn-warning btn-sm"
               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('abilities.entity-add', $model) }}">
                <x-icon class="plus"></x-icon> <span class="hidden-sm hidden-xs">{{ __('abilities.children.actions.add') }}</span>
            </a>
        </div>
    @endcan
@endsection


@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('abilities'), 'label' => \App\Facades\Module::plural(config('entities.ids.ability'), __('entities.abilities'))],
                __('abilities.show.tabs.entities')
            ]
        ])

        @include('abilities._menu', ['active' => 'entities'])

        <div class="entity-main-block">
            @include('abilities.panels.entities')
        </div>
    </div>
@endsection
