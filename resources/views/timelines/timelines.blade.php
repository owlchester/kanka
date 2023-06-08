@php
    $plural = \App\Facades\Module::plural(config('entities.ids.timeline'), __('entities.timelines'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('entity-header-actions')
    <div class="header-buttons inline-block pull-right ml-auto">
        @if (request()->has('parent_id'))
            <a href="{{ route('timelines.timelines', [$model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('timelines.timelines', [$model, 'parent_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden-sm hidden-xs">{{ __('crud.filters.direct') }}</span>
                ({{ $model->timelines()->count() }})
            </a>
        @endif
    </div>
@endsection

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($name), 'label' => $plural],
                $plural
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'timelines'])

        <div class="entity-main-block">
            @include('timelines.panels.timelines')
        </div>
    </div>
@endsection
