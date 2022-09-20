<?php /**
 * @var \App\Models\TimelineEra $era */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('timelines/eras.reorder.title'),
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
        ['url' => Breadcrumb::index('timelines'), 'label' => __('timelines.index.title')],
        ['url' => route('timelines.show', $timeline->id), 'label' => $timeline->name],
        __('timelines/eras.reorder.title')
            ]
        ])

        @include('timelines._menu', ['active' => 'reorder', 'model' => $timeline])

        <div class="entity-main-block">
            @include('timelines.eras._reorder')
        </div>
    </div>
@endsection



@section('styles')
    @parent
    <link href="{{ mix('css/story.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/story.js') }}" defer></script>
@endsection
