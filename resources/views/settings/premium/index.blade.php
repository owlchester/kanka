<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => __('settings.menu.premium'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-grid type="1/1">
        @include('partials.errors')

        <div class="flex gap-1 justify-between">
            <h1 class="text-2xl">
                {{ __('settings.menu.premium') }}
            </h1>

            @if (config('app.debug'))
                <a href="{{ route('settings.switch-back') }}" class="btn2 btn-xs btn-outline btn-error">
                    Switch to legacy
                </a>
            @endif
        </div>

        <x-box>
            <x-grid type="1/1">
                <h3 class="text-xl">{{ __('settings/boosters.pitch.title') }}</h3>
                <p class="">{{ __('settings/premium.pitch.description') }}</p>

                <div class="flex flex-col gap-2">
                    <h4 class="text-lg">{{ __('settings/premium.pitch.title') }}</h4>
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-1 mb-3">
                        <div class="flex items-center">
                            <div class="p-1 w-12 flex-none text-center">
                                <x-icon class="fa-regular fa-palette fa-2x text-neutral-content" />
                            </div>
                            <div class="p-1">
                                {{ __('settings/boosters.pitch.benefits.customisable') }}
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="p-1 w-12 flex-none text-center">
                                <x-icon class="fa-regular fa-puzzle-piece fa-2x text-neutral-content" />
                            </div>
                            <div class="p-1">
                                {{ __('settings/boosters.pitch.benefits.plugins') }}
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="p-1 w-12 flex-none text-center">
                                <x-icon class="fa-regular fa-hourglass-half fa-2x text-neutral-content" />
                            </div>
                            <div class="p-1">
                                {{ __('settings/boosters.pitch.benefits.backup', ['amount' => config('entities.hard_delete')]) }}
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="p-1 w-12 flex-none text-center">
                                <x-icon class="fa-regular fa-horse-head fa-2x text-neutral-content" />
                            </div>
                            <div class="p-1">
                                {{ __('settings/boosters.pitch.benefits.icons') }}
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="p-1 w-12 flex-none text-center">
                                <x-icon class="fa-regular fa-camera fa-2x text-neutral-content" />
                            </div>
                            <div class="p-1">
                                {{ __('settings/boosters.pitch.benefits.upload') }}
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="p-1 w-12 flex-none text-center">
                                <x-icon class="fa-regular fa-circle-nodes fa-2x text-neutral-content" />
                            </div>
                            <div class="p-1">
                                {{ __('settings/boosters.pitch.benefits.visual') }}
                            </div>
                        </div>
                    </div>
                </div>
                <p>
                    <a href="https://kanka.io/premium?utm_source=premium" class="text-link">
                        {!! __('callouts.premium.learn-more') !!}
                    </a>
                </p>
            </x-grid>
        </x-box>


        <div class="flex gap-2 items-center justify-between">
            <h2 class="">
                {{ __('settings/premium.ready.title') }}
            </h2>
            @can('boost', auth()->user())
                <div class="badge bg-boost flex gap-2 items-center" data-toggle="tooltip" data-title="{{ __('settings/premium.ready.available') }}">
                    <x-icon class="premium" />
                    {{ auth()->user()->availableBoosts() }} / {{ auth()->user()->maxBoosts() }}
                </div>
            @endif
        </div>

        @if (!auth()->user()->isGoblin())
        <p>{!! __('settings/premium.ready.pricing', [
        'amount' => '<strong>' . __('settings/boosters.ready.pricing-amount', [
            'currency' => auth()->user()->currencySymbol(),
            'amount' => '5.00'
        ]) . '</strong>'
        ]) !!}</p>
        @endif

        <div class="grid grid-cols-1 gap-2 campaign-list">
            @foreach ($premiums as $premium)
                @include('settings.boosters._campaign', ['campaign' => $premium->campaign])
            @endforeach
            @foreach ($campaigns as $userCampaign)
                @include('settings.boosters._campaign', ['campaign' => $userCampaign])
            @endforeach
        </div>
    </x-grid>

@endsection

@section('modals')
    @parent
    @if ($focus)
        <input type="hidden" id="focus-modal" data-url="{{ route('campaign_boosts.create', ['campaign' => $focus, 'boost' => 1]) }}" data-target="primary-dialog" />
    @endif
@endsection

@section('scripts')
    @parent
    @vite('resources/js/settings.js')
@endsection
