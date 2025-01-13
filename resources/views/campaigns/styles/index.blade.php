<?php /** @var \App\Models\CampaignStyle $style */
use App\Facades\Datagrid ?>
@extends('layouts.app', [
    'title' => __('campaigns/styles.title', ['campaign' => $campaign->name]),
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
        <div class="flex gap-2">
            <h3 class="grow">
                {{ __('campaigns.show.tabs.styles') }}
            </h3>
            <div class="flex gap-2 flex-wrap items-center justify-end">
                <a href="https://docs.kanka.io/en/latest/features/campaigns/theming.html" class="btn2 btn-sm btn-ghost">
                    <x-icon class="question" />
                    {{ __('crud.actions.help') }}
                </a>
                @if ($campaign->boosted())
                    <a href="{{ route('campaign_styles.create', $campaign) }}" class="btn2 btn-primary btn-sm">
                        <x-icon class="plus" />
                        {{ __('campaigns/styles.actions.new') }}
                    </a>
                @endif
            </div>
        </div>
        @if (!$campaign->boosted())
            <x-cta :campaign="$campaign" :image="false">
                <p>{!! __('campaigns/styles.pitch') !!}</p>
            </x-cta>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <x-infoBox
                :title="__('campaigns/styles.theme.override')"
                :icon="!empty($theme) ? 'fa-solid fa-check text-green-600' : 'fa-solid fa-user text-neutral-content'"
                :subtitle="!empty($theme) ? $theme->__toString() : __('campaigns/styles.theme.none')"
                background="{{ !empty($theme) ? 'bg-green-200' : 'bg-neutral' }}"
                :campaign="$campaign"
                :url="$campaign->boosted() ? route('campaign-theme', $campaign) : null"
                :urlTooltip="__('campaigns/styles.theme.title')"
                ajax
            ></x-infoBox>
        </div>
        @if ($styles->count() === 0)
            <x-box>
                <x-helper>
                    {!! __('campaigns/styles.helpers.main', ['here' => '<a href="https://blog.kanka.io/category/tutorials" target="_blank">' . __('campaigns/styles.helpers.here') . '</a>']) !!}
                </x-helper>
            </x-box>
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

        @if ($campaign->boosted())
            @includeWhen(!$reorderStyles->isEmpty(), 'campaigns.styles._reorder')
        @endif

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
