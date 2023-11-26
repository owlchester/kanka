<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 * @var \App\Services\SubscriptionService $service
 * @var \App\User $user
 */

?>
@extends('layouts.app', [
    'title' => __('settings.subscription.manage_subscription'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@section('content')
    <x-grid type="1/1">
        <h1>{{ __('settings.subscription.manage_subscription') }}</h1>

        <p class="text-lg">
            {!! __('subscription.benefits.main', [
                'more' => link_to(Domain::toFront('pricing'), __('subscription.benefits.more'), '#paid-features'),
                'boosters' => link_to(Domain::toFront('premium'), __('concept.premium-campaigns')),
                'stripe' => link_to('https://www.stripe.com', 'Stripe', ['target' => '_blank'])
            ]) !!}
        </p>

        @include('partials.errors')
        @if (session('sub_value'))
            <div class="text-center">
                <p>
                    <a  href="{{ route('settings.premium') }}" class="btn2 btn-primary btn-lg mr-4" target="blank">
                        <i class="fa-solid fa-rocket mr-1" aria-hidden="true"></i>
                        {{ __('settings/premium.ready.title') }}
                    </a>
                    @if (!$user->discord())
                        <a  href="{{ route('settings.apps') }}" class="btn2 btn-primary btn-lg ml-4" target="blank">
                            <i class="fa-brands fa-discord mr-1" aria-hidden="true"></i>
                            {{ __('settings.apps.discord.unlock') }}
                        </a>
                    @endif
                </p>
            </div>
        @endif
        @include('settings.subscription._recap')

        <div class="flex gap-2">
            <h2 class="grow m-0">
                {{ __('settings.subscription.tiers') }}
            </h2>
            <x-buttons.confirm type="ghost" target="change-information" size="sm">
                <x-icon class="question"></x-icon>
                <span>{{ __('settings.subscription.upgrade_downgrade.button') }}</span>
            </x-buttons.confirm>
        </div>
    <div class="text-center text-vertical">
        <span>{{ __('tiers.periods.monthly') }}</span>
        <label class="toggle mx-1">
            <input type="checkbox" name="period">
            <span class="slider subscription-period-slider"></span>
        </label>
        <span>{{ __('tiers.toggle.yearly') }}</span>
    </div>

    <div class="rounded bg-box period-month overflow-x-auto" id="pricing-overview">
        <div class="grid grid-cols-4 tiers gap-2 items-center pl-2 pr-2 min-w-fit">
            <div class="pt-5 tier flex gap-2 items-center flex-col xl:flex-row text-center xl:text-left">
                <img class="rounded-full" src="https://th.kanka.io/Xy0Dm1dMld_NUYYA2gJdTkKnqjE=/60x60/smart/src/app/tiers/kobold-750.png" alt="Kobold"/>
                <div class="text grow">
                    KOBOLD
                    <span class="price">
                        {{ __('front.features.patreon.free') }}
                    </span>
                </div>
            </div>
            <div class="pt-5 tier flex gap-2 items-center flex-col xl:flex-row text-center xl:text-left">
                <img class="rounded-full" src="https://th.kanka.io/s17BtlhzUJp4h07gxtzmljKO3fU=/60x60/smart/src/app/tiers/owlbear-750.png" alt="Owlbear"/>
                <div class="text grow flex flex-col">
                    <span class="tiername">OWLBEAR</span>
                    <div class="price price-monthly flex flex-wrap gap-1">
                        <span class="currency">{{ $user->currencySymbol() }}</span>
                        <span class="amount">5</span>
                        <span class="">{{ __('tiers.periods.monthly') }}</span>
                    </div>
                    <div class="price price-yearly flex flex-wrap gap-1">
                        <span class="currency">{{ $user->currencySymbol() }}</span>
                        <span class="amount">55</span>
                        <span class="">{{ __('tiers.periods.yearly') }}</span>
                    </div>
                </div>
                <div class="ribbon ribbon-top-right">
                    <span class="bg-green-500 text-white">{{ __('tiers.ribbons.popular') }}</span>
                </div>
            </div>
            <div class="pt-5 tier flex gap-2 items-center flex-col xl:flex-row text-center xl:text-left">
                <img class="rounded-full" src="https://th.kanka.io/rJBeW_Poe2uvjdo44f2yzDnofzo=/60x60/smart/src/app/tiers/wyvern-750.png" alt="Wyvern"/>
                <div class="text grow flex flex-col">
                    <span class="tiername">WYVERN</span>
                    <div class="price price-monthly flex flex-wrap gap-1">
                        <span class="currency">{{ $user->currencySymbol() }}</span>
                        <span class="amount">10</span>
                        <span class="">{{ __('tiers.periods.monthly') }}</span>
                    </div>
                    <div class="price price-yearly flex flex-wrap gap-1">
                        <span class="currency">{{ $user->currencySymbol() }}</span>
                        <span class="amount">110</span>
                        <span class="">{{ __('tiers.periods.yearly') }}</span>
                    </div>
                </div>
                <div class="ribbon ribbon-top-right">
                    <span class="bg-pink-500 text-white">{{ __('tiers.ribbons.best-value') }}</span>
                </div>
            </div>
            <div class="pt-5 tier flex gap-2 align-center flex-col xl:flex-row text-center xl:text-left">
                <img class="img-circle" src="https://th.kanka.io/Wira7yc1p1cAa_GUwC0SGDOuSwg=/60x60/smart/src/app/tiers/elemental-750.png" alt="Elemental"/>
                <div class="grow text flex flex-col">
                    <span class="tiername">ELEMENTAL</span>
                    <div class="price price-monthly flex flex-wrap gap-1">
                        <span class="currency">{{ $user->currencySymbol() }}</span>
                        <span class="amount">25</span>
                        <span class="">{{ __('tiers.periods.monthly') }}</span>
                    </div>
                    <div class="price price-yearly flex flex-wrap gap-1">
                        <span class="currency">{{ $user->currencySymbol() }}</span>
                        <span class="amount">275</span>
                        <span class="">{{ __('tiers.periods.yearly') }}</span>
                    </div>
                </div>
            </div>
            @if ($user->isLegacyPatron())
                <div class="col-span-4 text-center">
                    <x-alert type="warning">
                        {!! __('settings.subscription.warnings.patreon', ['patreon' => link_to_route('settings.patreon', __('settings.menu.patreon'))]) !!}
                    </x-alert>
                </div>
            @elseif($user->hasIncompletePayment('kanka'))
                <div class="col-span-4 text-center">
                    <x-alert type="warning">
                        {!! __('settings.subscription.warnings.incomplete') !!}
                    </x-alert>
                </div>
            @else
                @if ($user->hasPayPal())
                    @include('settings.subscription._paypal_buttons', ['toggle' => true])
                @else
                    @include('settings.subscription._buttons', ['toggle' => true])
                @endif
            @endif
            @include('settings.subscription._benefits')
        </div>
    </div>

    <p class="text-neutral-content">
        {!! __('settings.subscription.trial_period', ['email' => link_to('mailto:' .  config('app.email'), config('app.email'))]) !!}
    </p>
    </x-grid>
    <input type="hidden" id="stripe-token" value="{{ config('services.stripe.key') }}" />
@endsection

@section('modals')
    @parent

    <x-dialog id="change-information" :title="__('settings.subscription.upgrade_downgrade.button')">

        <h4>{{ __('settings.subscription.upgrade_downgrade.upgrade.title') }}</h4>
        <ul class="">
            @foreach(__('settings.subscription.upgrade_downgrade.upgrade.bullets') as $key => $text)
                <li>{{ $text }}</li>
            @endforeach
        </ul>

        <h4>{{ __('settings.subscription.upgrade_downgrade.downgrade.title') }}</h4>
        <ul class="">
            @foreach(__('settings.subscription.upgrade_downgrade.downgrade.bullets') as $key => $text)
                <li>{{ $text }}</li>
            @endforeach
        </ul>

        <h4>{{ __('settings.subscription.upgrade_downgrade.cancel.title') }}</h4>
        <ul>
            <li>{{ __('settings.subscription.upgrade_downgrade.cancel.bullets.kobold') }}</li>
            <li>{{ __('settings.subscription.upgrade_downgrade.cancel.bullets.bonuses') }}</li>
            <li>{{ __('settings.subscription.upgrade_downgrade.cancel.bullets.premium') }}</li>
        </ul>
    </x-dialog>

    <x-dialog id="subscribe-confirm" :loading="true"></x-dialog>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/subscription.js')
    <script src="https://js.stripe.com/v3/"></script>

@if($tracking == 'subscribed')
    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-659212134/z5nbCLmq0fsBEOaOq7oC',
            'transaction_id': '{{ auth()->user()->id }}'
        });
    </script>
@endif
@endsection

@section('styles')
    @vite('resources/sass/subscription.scss')
@endsection
