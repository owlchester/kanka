<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => __('settings/boosters.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@section('content')
    <x-grid type="1/1">
        @include('partials.errors')

        <h1 class="text-2xl">
            <x-icon class="premium" />
            {{ __('settings/boosters.title') }}
        </h1>

        @if (auth()->user()->hasLegacyBoosterNomenclature())
            <x-alert type="warning">
                <x-grid type="1/1">
                    <h3 class="m-0 text-xl">Legacy boosters</h3>
                    <p>
                        You're currently using Kanka's legacy booster system. You can switch to premium campaigns at any time. When you switch, your existing campaigns will be unboosted, and you’ll receive premium campaign slots based on your subscription: {{ config('limits.') }} for Owlbear, 3 for Wyvern, or 7 for Elemental.
                    </p>
                    <p>
                        Premium campaigns include everything previously available to superboosted campaigns, plus features such as family trees and custom modules.
                    </p>
                    <p>
                        This change is permanent and cannot be undone.
                    </p>

                    <button class="btn2 btn-block btn-secondary"
                            data-toggle="dialog"
                            data-target="switch-dialog">
                        Switch to premium campaigns
                    </button>
                </x-grid>
            </x-alert>
        @endif

        @include('settings.premium.benefits', ['boosters' => true])

        <h2 class="">
            {{ __('settings/boosters.ready.title') }}

            @can('boost', auth()->user())
                <div class="badge bg-boost flex gap-1 badge-lg ml-2" data-toggle="tooltip" data-title="{{ __('settings/boosters.ready.available') }}">
                    <x-icon class="premium" />
                    {{ auth()->user()->availableBenefits() }}
                </div>
            @endif
        </h2>
        @if (!auth()->user()->isGoblin())
        <p>{!! __('settings/boosters.ready.pricing', [
        'amount' => '<strong>' . __('settings/boosters.ready.pricing-amount', [
            'currency' => auth()->user()->currencySymbol(),
            'amount' => '5.00'
        ]) . '</strong>'
        ]) !!}</p>
        @endif

        @if ($focus)
            @include('settings.boosters.create', [
                'campaign' => $focus,
                'superboost' => $superboost,
                'cost' => $superboost ? 3 : 1,
                'canSuperboost' => auth()->user()->availableBenefits() >= 3
            ])
        @endif

        <div class="grid grid-cols-1 gap-2 campaign-list">
            @foreach ($boosts as $boost)
                @include('settings.boosters._campaign', ['campaign' => $boost->campaign])
            @endforeach
            @foreach ($campaigns as $c)
                @include('settings.boosters._campaign', ['campaign' => $c])
            @endforeach
        </div>
    </x-grid>
@endsection

@section('modals')
    @parent

    <x-dialog id="switch-dialog" title="Switch to premium campaigns?">
        <x-grid type="1/1">
            <p>
                Are you sure you want to switch? Your existing campaigns will be unboosted, and you’ll receive premium campaign slots based on your subscription.
            </p>
            <p>This change is permanent and cannot be undone.</p>

        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>
            <form method="POST" action="{{ route('settings.switch-to-premium') }}" class="w-full">
            <x-buttons.confirm type="primary" full="true">
                Yes, switch to premium campaigns
            </x-buttons.confirm>
                @csrf
            </form>
        </div>

        </x-grid>
    </x-dialog>
@endsection

@section('scripts')
    @parent
    @vite('resources/js/settings.js')
@endsection
