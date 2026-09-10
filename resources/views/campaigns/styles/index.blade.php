<?php /** @var \App\Models\CampaignStyle $style */
use App\Facades\Datagrid ?>
@extends('layouts.app', [
    'title' => __('campaigns/styles.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.styles')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('partials.errors')

    <div class="flex gap-5 flex-col">
        <div class="flex gap-2 justify-between">
            <h1 class="text-2xl">
                {{ __('campaigns.show.tabs.styles') }}
            </h1>
            <div class="flex gap-2 flex-wrap items-center justify-end">
                <x-learn-more url="features/campaigns/theming.html" />
                @if ($campaign->boosted())
                    <a href="{{ route('campaign_styles.builder', $campaign) }}" class="btn2 btn-primary btn-sm">
                        <x-icon class="fa-regular fa-palette" />
                        {{ __('campaigns/styles.actions.builder') }}
                    </a>
                    <a href="{{ route('campaign_styles.create', $campaign) }}" class="btn2 btn-primary btn-sm">
                        <x-icon class="plus" />
                        {{ __('campaigns/styles.actions.new') }}
                    </a>
                @endif
            </div>
        </div>

        <p class="max-w-4xl text-lg">
            {!! __('campaigns/styles.helpers.tutorial') !!}
        </p>

        @if (!$campaign->boosted())
            <x-premium-cta-alert :campaign="$campaign" source="theming">
                <x-slot name="title">
                    {!! __('campaigns/styles.cta.title') !!}
                </x-slot>
                <x-slot name="lead">
                    {!! __('campaigns/styles.cta.lead') !!}
                </x-slot>
            </x-premium-cta-alert>
        @endif

        <x-infoBox
            :title="__('campaigns/styles.theme.override')"
            :icon="!empty($theme) ? 'fa-solid fa-check text-success-content' : 'fa-solid fa-user text-neutral-content'"
            :subtitle="!empty($theme) ? $theme->__toString() : __('campaigns/styles.theme.none')"
            background="{{ !empty($theme) ? 'bg-green-200' : 'bg-neutral' }}"
            :campaign="$campaign"
            :url="$campaign->boosted() ? route('campaign-theme', $campaign) : null"
            :urlTooltip="__('campaigns/styles.theme.title')"
            ajax
        ></x-infoBox>
        @if ($styles->count() === 0)
            <x-box class="border-dashed border-neutral-content border">
                <div class="mx-auto max-w-2xl lg:p-4 flex flex-col items-center gap-2">
                    <div class="font-bold text-lg">{{ __('campaigns/styles.helpers.empty')}}</div>

                    @if ($campaign->boosted())
                        <p class="text-neutral-content mb-4">
                            {{ __('campaigns/styles.helpers.what') }}
                        </p>

                        <a href="{{ route('campaign_styles.create', $campaign) }}" class="btn2 btn-primary">
                            <x-icon class="plus" />
                            {{ __('campaigns/styles.actions.new_first') }}
                        </a>
                    @else
                        <p class="text-neutral-content mb-4">
                            {{ __('campaigns/styles.cta.helper') }}
                        </p>

                        <a href="{{ route('settings.subscription', ['f' => 'cta', 's' => 'theming', 'w' => $campaign->id]) }}" class="btn2 btn-primary">
                            {!! __('callouts.actions.subscription') !!}
                            <i class="fa-regular fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    @endif

                </div>
            </x-box>

            <x-helper>
                <p>{!! __('campaigns/styles.helpers.main', ['here' => '<a href="https://blog.kanka.io/category/tutorials" target="_blank" class="text text-link">' . __('campaigns/styles.helpers.here') . '</a>']) !!}</p>
            </x-helper>
        @else
            @if(Datagrid::hasBulks())
                <x-form :action="['campaign_styles.bulk', $campaign]" direct>
                    <div id="datagrid-parent" class="table-responsive">
                        @include('layouts.datagrid._table', ['rows' => $styles])
                    </div>
                </x-form>
            @else
                <div id="datagrid-parent" class="table-responsive">
                    @include('layouts.datagrid._table', ['rows' => $styles])
                </div>
            @endif
        @endif

        @includeWhen($campaign->boosted() && $reorderStyles->count() > 1, 'campaigns.styles._reorder')
    </div>
@endsection


@section('modals')

    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])

    @include('partials.helper-modal', [
        'id' => 'theming-help',
        'title' => __('campaigns.show.tabs.styles'),
        'textes' => [
            __('campaigns/styles.helpers.main', ['here' => '<a href="https://blog.kanka.io/category/tutorials" target="_blank">' . __('campaigns/styles.helpers.here') . '</a>']),
    ]])

@endsection
