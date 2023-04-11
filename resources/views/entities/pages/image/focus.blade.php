<?php /** @var \App\Models\Entity $entity */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/image.focus.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('entities/image.focus.breadcrumb')
    ],
    'bodyClass' => 'entity-image-focus'
])
@inject('campaignService', 'App\Services\CampaignService')


@section('content')

    @include('partials.errors')
    <div class="rounded p-4 bg-box max-w-4xl">
        @if ($campaignService->campaign()->boosted())
            @if($campaignService->campaign()->superboosted() && empty($model->image) && !empty($entity->image_uuid))
                <p class="alert alert-warning">
                    {{ __('entities/image.focus.warning') }}
                </p>
                <p>
                    <a href="{{ $model->getLink() }}">
                        <i class="fa-regular fa-arrow-left" aria-hidden="true"></i>
                        {{ __('crud.actions.back') }}
                    </a>
                </p>
            @else

        <p class="help-block">{{ __('entities/image.focus.helper') }}</p>

        <div class="focus-selector max-h-screen relative mb-2 overflow-auto">
            <div class="focus absolute text-white cursor-pointer text-3xl" style="@if(empty($entity->focus_x))display: none; @else left: {{ $entity->focus_x }}px; top: {{ $entity->focus_y }}px; @endif">
                <i class="fa-regular fa-bullseye fa-2x hover:text-red" aria-hidden="true"></i>
            </div>

            <img class="focus-image max-w-none" src="{{ $model->thumbnail(0) }}" alt="img" />
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
            <p class="alert alert-warning">
                {!! __('entities/image.focus.unboosted', [
        'boosted-campaigns' => link_to_route('front.pricing', __('crud.boosted_campaigns'), ['#boost'], ['target' => '_blank'])
    ]) !!}
            </p>
            <a href="{{ $model->getLink() }}">
                <i class="fa-regular fa-arrow-left" aria-hidden="true"></i>
                {{ __('crud.actions.back') }}
            </a>
        @endif
    </div>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/story.js')
@endsection
