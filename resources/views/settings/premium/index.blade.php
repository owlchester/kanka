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

        <h1 class="">
            {{ __('settings.menu.premium') }}
        </h1>

        @if (app()->environment('local'))
            <a href="{{ route('settings.switch-back') }}" class="btn2 btn-primary">
                Switch to legacy
            </a>
        @endif

        <x-box>
            <h3 class="">{{ __('settings/boosters.pitch.title') }}</h3>
            <p class="">{{ __('settings/premium.pitch.description') }}</p>

            <h4 class="">{{ __('settings/premium.pitch.title') }}</h4>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-1 mb-3">
                <div class="flex items-center">
                    <div class="p-1 w-12 flex-none">
                        <i class="fa-solid fa-palette fa-2x" aria-hidden="true"></i>
                    </div>
                    <div class="p-1">
                        {{ __('settings/boosters.pitch.benefits.customisable') }}
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-1 w-12 flex-none">
                        <i class="fa-solid fa-image-portrait fa-2x" aria-hidden="true"></i>
                    </div>
                    <div class="p-1">
                        {{ __('settings/boosters.pitch.benefits.entities') }}
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-1 w-12 flex-none">
                        <i class="fa-solid fa-hourglass-half fa-2x" aria-hidden="true"></i>
                    </div>
                    <div class="p-1">
                        {{ __('settings/boosters.pitch.benefits.backup', ['amount' => config('entities.hard_delete')]) }}
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-1 w-12 flex-none">
                        <i class="fa-solid fa-horse-head fa-2x" aria-hidden="true"></i>
                    </div>
                    <div class="p-1">
                        {{ __('settings/boosters.pitch.benefits.icons') }}
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-1 w-12 flex-none">
                        <i class="fa-solid fa-camera fa-2x" aria-hidden="true"></i>
                    </div>
                    <div class="p-1">
                        {{ __('settings/boosters.pitch.benefits.upload') }}
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-1 w-12 flex-none">
                        <i class="fa-solid fa-user-group fa-2x" aria-hidden="true"></i>
                    </div>
                    <div class="p-1">
                        {{ __('settings/boosters.pitch.benefits.relations') }}
                    </div>
                </div>
            </div>
            <p>{!! __('settings/premium.pitch.more', ['premium' => '<a href="https://kanka.io/premium" target="_blank">' . __('concept.premium-campaigns') . '</a>']) !!}</p>

        </x-box>


        <h2 class="">
            {{ __('settings/premium.ready.title') }}

            @if (auth()->user()->hasBoosters() || !empty(auth()->user()->booster_count))
                <div class="badge bg-boost border-0 badge-lg flex gap-1 ml-3" data-toggle="tooltip" data-title="{{ __('settings/premium.ready.available') }}">
                    <x-icon class="premium" />
                    {{ auth()->user()->availableBoosts() }}
                </div>
            @endif
        </h2>
        @if (!auth()->user()->isGoblin())
        <p>{!! __('settings/premium.ready.pricing', [
        'amount' => '<strong>' . __('settings/boosters.ready.pricing-amount', [
            'currency' => auth()->user()->currencySymbol(),
            'amount' => '5.00'
        ]) . '</strong>'
        ]) !!}</p>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 campaign-list">
            @foreach ($premiums as $premium)
                @include('settings.boosters._campaign', ['campaign' => $premium->campaign])
            @endforeach
            @foreach ($campaigns as $userCampaign)
                @include('settings.boosters._campaign', ['campaign' => $userCampaign])
            @endforeach
        </div>
    </x-grid>

@endsection

@section('styles')
    @parent
    @vite('resources/sass/settings.scss')
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
