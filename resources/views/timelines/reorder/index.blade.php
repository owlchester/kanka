<?php /**
 * @var \App\Models\TimelineEra $era */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('timelines.reorder.title'),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $timeline,
    'bodyClass' => 'timeline-eras-reorder'
])
@inject('campaignService', 'App\Services\CampaignService')


@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $timeline,
            'breadcrumb' => [
        ['url' => Breadcrumb::index('timelines'), 'label' => __('entities.timelines')],
        __('timelines.reorder.title')
            ]
        ])

        @include('timelines._menu', ['active' => 'reorder', 'model' => $timeline])

        <div class="entity-main-block">
            @include('timelines.reorder._reorder')
        </div>
    </div>
@endsection
