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
            <a href="{{ route('timelines.timelines', [$model]) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('timelines.timelines', [$model, 'parent_id' => $model->id]) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->timelines()->count() }})
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

        @include($name . '._menu', ['active' => 'timelines'])

        <div class="entity-main-block">
            @include('timelines.panels.timelines')
        </div>
    </div>
@endsection
