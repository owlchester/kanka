<?php /** @var \App\Models\Entity $entity */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/image.focus.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => \App\Facades\Module::plural($entity->typeId(), __('entities.' . $entity->pluralType()))],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('entities/image.focus.breadcrumb')
    ],
    'bodyClass' => 'entity-image-focus'
])
@inject('campaignService', 'App\Services\CampaignService')


@section('content')

    @include('partials.errors')
    <div class="max-w-4xl">
        <x-box>
        @if ($campaignService->campaign()->boosted())
            @if($campaignService->campaign()->superboosted() && empty($model->image) && !empty($entity->image_uuid))
                <x-alert type="warning">
                    {{ __('entities/image.focus.warning') }}
                </x-alert>
                <p>
                    <a href="{{ $model->getLink() }}">
                        <x-icon class="fa-regular fa-arrow-left"></x-icon>
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


        <x-dialog.footer>
            <button type="submit" class="btn2 btn-primary">
                {{ __('entities/image.actions.save_focus') }}
            </button>
        </x-dialog.footer>
        {!! Form::close() !!}
            @endif

        @else
            <x-alert type="warning">
                {!! __('entities/image.focus.unboosted', [
        'boosted-campaigns' => link_to_route('front.pricing', __('concept.premium-campaigns'), ['#premium'])
    ]) !!}
            </x-alert>
            <a href="{{ $model->getLink() }}">
                <x-icon class="fa-regular fa-arrow-left"></x-icon>
                {{ __('crud.actions.back') }}
            </a>
        @endif
        </x-box>
    </div>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/story.js')
@endsection
