<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => __('campaigns/default-images.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns/default-images.title')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')

    <div class="flex gap-5 flex-col">
        @include('partials.errors')
        <div class="flex gap-2 items-center">
            <h1 class="inline-block grow text-2xl">
                {{ __('campaigns/default-images.title') }}
            </h1>
            <x-learn-more url="features/campaigns/default-thumbnails.html" />
            @if ($campaign->boosted())
                @can('recover', $campaign)
                <a href="{{ route('campaign.default-images.create', $campaign) }}" class="btn2 btn-primary btn-sm"
                   data-toggle="dialog-ajax" data-target="new-thumbnail"
                   data-url="{{ route('campaign.default-images.create', $campaign) }}">
                    <x-icon class="plus" />
                    {{ __('campaigns/default-images.actions.add') }}
                </a>

                <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="reset-confirm">
                    <x-icon class="fa-regular fa-eraser" />
                    {{ __('crud.actions.reset') }}
                </a>
                @endif
            @endif
        </div>
        @if ($campaign->boosted())
            <p>{{ __('campaigns/default-images.tutorial') }}</p>
            @if (empty($images))
                <p class="italic">{{ __('campaigns/default-images.empty') }}</p>
            @endif
            <div class="grid grid-cols-1 gap-2 md:gap-3 xl:grid-cols-2 xl:gap-5">
                @foreach ($images as $image)
                    @if (!\Illuminate\Support\Arr::has($entityTypes, $image['type']))
                        @continue
                    @endif
                    @include('campaigns.default-images._thumbnail')
                @endforeach

            </div>
        @else
            <x-premium-cta :campaign="$campaign">
                <p>{{ __('campaigns/default-images.call-to-action') }}</p>
            </x-premium-cta>
        @endif
    </div>
@endsection

@section('modals')
    @parent
    <x-dialog id="new-thumbnail" :loading="true" />

    <x-dialog id="reset-confirm" :title="__('campaigns/default-images.reset.title')">
        <x-grid type="1/1">
            <x-helper>
                <p>{{ __('campaigns/default-images.reset.helper') }}</p>
                <p>{{ __('campaigns/default-images.reset.warning') }}</p>
            </x-helper>

            <div class="grid grid-cols-2 gap-2 w-full">
                <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                    {{ __('crud.cancel') }}
                </x-buttons.confirm>

                <x-form method="DELETE" :action="['campaign.default-images.reset', $campaign]">
                <x-buttons.confirm type="danger" full="true" outline="true">
                    {{ __('crud.actions.confirm') }}
                </x-buttons.confirm>
                </x-form>
            </div>
        </x-grid>
    </x-dialog>
@endsection
