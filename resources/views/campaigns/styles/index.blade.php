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
        <div class="flex gap-2 items-center flex-wrap">
            <h3 class="inline-block grow">
                {{ __('campaigns.show.tabs.styles') }}
            </h3>
            @if ($campaign->boosted())
                <button class="btn2 btn-sm btn-ghost ml-1" data-toggle="dialog" data-target="theming-help">
                    <x-icon class="question" />
                    {{ __('crud.actions.help') }}
                </button>
                <a href="#" data-url="{{ route('campaign-theme', $campaign) }}" data-target="campaign-theme" data-toggle="dialog-ajax" class="btn2 btn-sm">
                    <x-icon class="fa-solid fa-brush" />
                    {{ __('campaigns/styles.actions.current', ['theme' => !empty($theme) ? $theme->__toString() : __('crud.filters.options.none')]) }}
                </a>
                <a href="{{ route('campaign_styles.create', $campaign) }}" class="btn2 btn-primary btn-sm">
                    <x-icon class="plus" />
                    {{ __('campaigns/styles.actions.new') }}
                </a>
            @endif
        </div>
        @if (!$campaign->boosted())
            <x-cta :campaign="$campaign">
                <p>{!! __('campaigns/styles.pitch') !!}</p>
            </x-cta>
        @else
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

            @includeWhen(!$reorderStyles->isEmpty(), 'campaigns.styles._reorder')
        @endif
    </div>
@endsection


@section('modals')

    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])

    <x-dialog id="campaign-theme" title="{{ __('Loading') }}" :loading="true"></x-dialog>

    @include('partials.helper-modal', [
        'id' => 'theming-help',
        'title' => __('campaigns.show.tabs.styles'),
        'textes' => [
            __('campaigns/styles.helpers.main', ['here' => '<a href="https://blog.kanka.io/category/tutorials" target="_blank">' . __('campaigns/styles.helpers.here') . '</a>']),
    ]])

@endsection
