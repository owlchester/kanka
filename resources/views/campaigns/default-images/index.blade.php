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
        <x-campaigns.page-header
            :title="__('campaigns/default-images.title')"
            learn-more-url="features/campaigns/default-thumbnails.html"
            :lead="__('campaigns/default-images.tutorial')"
        >
            <x-slot name="actions">
                @can('recover', $campaign)
                    <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="reset-confirm">
                        <x-icon class="fa-regular fa-eraser" />
                        {{ __('crud.actions.reset') }}
                    </a>
                    @if ($campaign->boosted())
                        <a href="{{ route('campaign.default-images.create', $campaign) }}" class="btn2 btn-primary btn-sm"
                           data-toggle="dialog"
                           data-url="{{ route('campaign.default-images.create', $campaign) }}">
                            <x-icon class="plus" />
                            {{ __('campaigns/default-images.actions.add') }}
                        </a>
                    @endif
                @endcan
            </x-slot>
        </x-campaigns.page-header>

        @if (!$campaign->boosted())
            <x-premium-cta-alert :campaign="$campaign" source="placeholder-images">
                <x-slot name="title">
                    {!! __('campaigns/default-images.cta.title') !!}
                </x-slot>
                <x-slot name="lead">
                    {!! __('campaigns/default-images.cta.lead') !!}
                </x-slot>
            </x-premium-cta-alert>
        @endif

        @if (empty($images))
            <x-box class="border-dashed border-neutral-content border">
                <div class="mx-auto max-w-2xl lg:p-4 flex flex-col items-center gap-2 text-center">
                    <div class="font-bold text-lg">{{ __('campaigns/default-images.empty.title') }}</div>
                    <p class="text-neutral-content mb-4">{{ __('campaigns/default-images.empty.description') }}</p>

                    @can('recover', $campaign)
                        @if ($campaign->boosted())
                            <a href="{{ route('campaign.default-images.create', $campaign) }}" class="btn2 btn-primary"
                               data-toggle="dialog"
                               data-url="{{ route('campaign.default-images.create', $campaign) }}">
                                <x-icon class="plus" />
                                {{ __('campaigns/default-images.actions.add') }}
                            </a>
                        @else
                            <a href="{{ route('settings.subscription', ['f' => 'cta', 's' => 'placeholder-images', 'w' => $campaign->id]) }}" class="btn2 btn-primary">
                                {!! __('callouts.actions.subscription') !!}
                                <i class="fa-regular fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        @endif
                    @endcan
                </div>
            </x-box>
        @else
            <div class="grid grid-cols-1 gap-2 md:gap-3 xl:grid-cols-2 xl:gap-5">
                @foreach ($images as $image)
                    @if (!\Illuminate\Support\Arr::has($entityTypes, $image['type']))
                        @continue
                    @endif
                    @include('campaigns.default-images._thumbnail')
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('modals')
    @parent

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
