<?php /**
 * @var \App\Models\TimelineEra $era */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('timelines/eras.reorder.title'),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('timelines'), 'label' => __('timelines.index.title')],
        ['url' => route('timelines.show', $timeline->id), 'label' => $timeline->name],
        __('timelines/eras.reorder.title')
    ],
    'mainTitle' => false,
    'bodyClass' => 'timeline-eras-reorder'
])
@inject('campaignService', 'App\Services\CampaignService')


@section('content')
    @include('partials.errors')

    {!! Form::open([
        'route' => ['timeline-eras.reorder-save', $timeline],
        'method' => 'POST',
    ]) !!}
    <div class="box box-solid box-entity-story-reorder">
        <div class="box-header">
            <h3 class="box-title">
                {{ __('timelines/eras.reorder.title') }}
            </h3>
        </div>
        <div class="box-body">
            <div class="element-live-reorder">
                @foreach($eras as $era)
                    <div class="element" data-id="{{ $era->id }}">
                        {!! Form::hidden('timeline_era[]', $era->id) !!}
                        <div class="dragger">
                            <span class="fa-solid fa-ellipsis-v visible-md visible-lg"></span>
                            <div class="visible-xs visible-sm">
                                <span class="fa-solid fa-arrow-up"></span><br />
                                <span class="fa-solid fa-arrow-down"></span>
                            </div>
                        </div>
                        <div class="name">
                            {!! $era->name !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="box-footer">

            <button class="btn btn-primary btn-block">
                {{ __('crud.save') }}
            </button>

        </div>
    </div>
    {!! Form::close() !!}
@endsection



@section('styles')
    @parent
    <link href="{{ mix('css/story.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/story.js') }}" defer></script>
@endsection
