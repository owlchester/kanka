<?php /** @var \App\Models\Entity $entity */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/image.focus.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('entities/image.focus.breadcrumb')
    ],
    'bodyClass' => 'entity-image-focus',
    'centered' => true,
])


@section('content')

    @include('partials.errors')
    <x-box>
    @if ($campaign->boosted())
        @if($campaign->superboosted() && empty($entity->image_path) && !empty($entity->image_uuid))
            <x-alert type="warning">
                <p>{!! __('entities/image.focus.warning_v2', ['gallery' => '<a href="' . route('gallery', $campaign) . '">' . __('sidebar.gallery') . '</a>']) !!}</p>
            </x-alert>
            <p>
                <a href="{{ $model->getLink() }}">
                    <x-icon class="fa-regular fa-arrow-left"></x-icon>
                    {{ __('crud.actions.back') }}
                </a>
            </p>
        @else

    <x-helper>{{ __('entities/image.focus.helper') }}</x-helper>

    <div class="focus-selector relative inline-block">
        <div class="focus absolute text-white drop-shadow cursor-pointer text-2xl" data-focus-x="{{ $entity->focus_x }}" data-focus-y="{{ $entity->focus_y }}" style="@if(empty($entity->focus_x))display: none; @endif">
            <x-icon class="fa-duotone fa-arrow-up-left-from-circle fa-2x hover:text-error" />
        </div>

        <img class="focus-image" src="{{ \App\Facades\Avatar::entity($entity)->original() }}" alt="img" />
    </div>

    <x-form :action="['entities.image.focus', $campaign, $entity]">
        <x-dialog.footer>
            <button type="submit" class="btn2 btn-primary">
                {{ __('entities/image.actions.save_focus') }}
            </button>
        </x-dialog.footer>
        <input type="hidden" name="focus_x" />
        <input type="hidden" name="focus_y" />
    </x-form>
        @endif

    @else
        <x-alert type="warning">
            <p>
            {!! __('entities/image.focus.unboosted', [
    'boosted-campaigns' => '<a href="https://kanka.io/premium" target="_blank">' . __('concept.premium-campaigns') . '</a>'
]) !!}
            </p>
        </x-alert>
        <a href="{{ $model->getLink() }}">
            <x-icon class="fa-regular fa-arrow-left"></x-icon>
            {{ __('crud.actions.back') }}
        </a>
    @endif
    </x-box>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/story.js')
@endsection
