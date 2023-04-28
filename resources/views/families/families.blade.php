@extends('layouts.app', [
    'title' => __('families.families.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('entity-header-actions')
    <div class="header-buttons inline-block pull-right ml-auto">
        @if (request()->has('parent_id'))
            <a href="{{ route('families.families', [$model]) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
            </a>
        @else
            <a href="{{ route('families.families', [$model, 'parent_id' => $model->id]) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->families()->count() }})
            </a>
        @endif
    </div>
@endsection

@php
    $plural = \App\Facades\Module::plural(config('entities.ids.family'), __('entities.families'));
@endphp
@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('families'), 'label' => $plural],
                $plural
            ]
        ])

        @include($name . '._menu', ['active' => 'families'])

        <div class="entity-main-block">
            @include('families.panels.families')
        </div>
    </div>
@endsection
