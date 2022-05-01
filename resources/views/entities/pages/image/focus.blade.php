<?php /** @var \App\Models\Entity $entity */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/image.focus.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('entities/image.focus.breadcrumb')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
    'bodyClass' => 'entity-image-focus'
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('entities/image.focus.panel_title') }}
            </h3>
        </div>
        <div class="box-body">

            @if ($campaign->campaign()->boosted())
                @if($campaign->campaign()->boosted(true) && empty($model->image) && !empty($entity->image_uuid))
                    <p class="alert alert-warning">
                        {{ __('entities/image.focus.warning') }}
                    </p>
                    <p>
                        <a href="{{ url()->previous() }}">
                            <i class="fa-solid fa-arrow-left"></i>
                            {{ __('crud.actions.back') }}
                        </a>
                    </p>
                @else

            <p class="help-block">{{ __('entities/image.focus.helper') }}</p>
            <div class="focus-selector">
                <div class="focus" style="@if(empty($entity->focus_x))display: none; @else left: {{ $entity->focus_x }}px; top: {{ $entity->focus_y }}px; @endif">
                    <i class="fa-solid fa-bullseye fa-2x"></i>
                </div>

                <img class="focus-image" src="{{ $model->getImageUrl(0) }}" alt="img" />
            </div>

            {!! Form::open([
    'route' => ['entities.image.focus', $entity],
    'method' => 'POST'
]) !!}
            {!! Form::hidden('focus_x', null) !!}
            {!! Form::hidden('focus_y', null) !!}

            <input type="submit" class="btn btn-block btn-primary" value="{{ __('entities/image.actions.save_focus') }}" />
            {!! Form::close() !!}
                @endif

            @else
                <p class="alert alert-warning">{!! __('entities/image.focus.unboosted', [
            'boosted-campaigns' => link_to_route('front.pricing', __('crud.boosted_campaigns'), ['#boost'], ['target' => '_blank'])
        ]) !!}</p>

            @endif
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
