<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 * @var \App\Services\SubscriptionService $service
 * @var \App\Models\User $user
 */

?>
@extends('layouts.app', [
    'title' => __('settings.subscription.manage_subscription'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-grid type="1/1">
        <h1>{{ __('settings.subscription.manage_subscription') }}</h1>

        <p class="">
            {!! __('subscription.benefits.main', [
                'more' => '<a href="https://kanka.io/pricing" target="_blank">' . __('subscription.benefits.more') . '</a>',
                'boosters' => '<a href="https://kanka.io/premium" target="_blank">' . __('concept.premium-campaigns') . '</a>',
                'stripe' => '<a href="https://stripe.com" target="_blank">Stripe</a>'
            ]) !!}
        </p>

        @include('partials.errors')
        @if (session('sub_value'))
            <div class="text-center">
                <p>
                    <a href="{{ route('settings.premium') }}" class="btn2 btn-primary btn-lg mr-4" target="blank">
                        <i class="fa-solid fa-gem mr-1" aria-hidden="true"></i>
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

        <h2 class="m-0">
            {{ __('settings.subscription.tiers') }}
        </h2>
        @if (!$isPayPal && !$hasManual)
            <div class="text-center text-vertical">
                <span>{{ __('tiers.periods.monthly') }}</span>
                <label class="toggle mx-1">
                    <input type="checkbox" name="period">
                    <span class="slider subscription-period-slider"></span>
                </label>
                <span>{{ __('tiers.toggle.yearly') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 @if ($user->isSubscriber()) lg:grid-cols-3 @else md:grid-cols-2 xl:grid-cols-4 @endif gap-4 @if ($isPayPal || $hasManual) period-year @else period-month @endif mx-auto lg:mx-0" id="pricing-overview">
            @php /** @var \App\Models\Tier $tier **/ @endphp
            @foreach ($tiers as $tier)
                @if ($tier->isFree() && $user->isSubscriber())
                    @continue
                @endif
                <div class="rounded-2xl bg-box flex flex-col gap-4 p-4 relative max-w-2xl lg:max-w-none shadow-xs hover:shadow @if ($tier->isCurrent($user)) drop-shadow border-primary border @endif">
                    <div class="flex gap-2 flex-col xl:flex-row">
                        <img class="rounded-full w-fit" src="{{ $tier->image() }}" alt="{{ $tier->name }}"/>
                        <div class="grow flex flex-col gap-2 w-full">
                            <div class="text-lg">
                                {{ $tier->name }}

                                @if ($tier->isCurrent($user))
                                @elseif ($tier->isPopular())
                                    <span class="bg-primary text-primary-content text-xs rounded-full px-2 py-1">{{ __('tiers.ribbons.popular') }}</span>
                                @elseif ($tier->isBestValue())
                                    <span class="bg-accent text-accent-content text-xs rounded-full px-2 py-1">{{ __('tiers.ribbons.best-value') }}</span>
                                @endif

                            </div>
                            @if ($tier->isFree())
                                <div class="price text-neutral-content">
                                    {{ __('front.features.patreon.free') }}
                                </div>
                            @else
                                <div class="price price-monthly flex gap-2 w-full items-end">
                                    <div class="text-4xl">
                                        {{ $user->currencySymbol() }}
                                        {{ number_format($tier->price($user->currency(), \App\Enums\PricingPeriod::Monthly), 2) }}
                                    </div>
                                    <span class="text-sm text-neutral-content ">{{ __('tiers.periods.billed_monthly') }}</span>
                                </div>
                                <div class="price price-yearly flex gap-2 w-full items-end">
                                    <div class="text-4xl">
                                        {{ $user->currencySymbol() }}
                                        {{ number_format($tier->price($user->currency(), \App\Enums\PricingPeriod::Yearly), 2) }}
                                    </div>
                                    <span class="text-sm text-neutral-content ">{{ __('tiers.periods.billed_yearly') }}</span>
                                </div>
                            @endif

                            @if ($tier->code === 'owlbear')
                                <p class="">{{ __('tiers.target.owlbear') }}</p>
                            @elseif ($tier->code === 'wyvern')
                                <p class="">{{ __('tiers.target.wyvern') }}</p>
                            @elseif ($tier->code === 'elemental')
                                <p class="">{{ __('tiers.target.elemental') }}</p>
                            @endif
                        </div>
                    </div>
                    @if (!$user->isLegacyPatron() && !$user->hasIncompletePayment('kanka'))
                        <div class="flex flex-col gap-1">
                            @include('settings.subscription.tiers.actions._' . $tier->code)
                        </div>
                    @endif
                    <div class="flex flex-col gap-2">
                        @includeIf('settings.subscription.tiers.benefits._' . $tier->code)
                    </div>
                    @if (!$tier->isFree() && $tier->isCurrent($user) && $user->subscribed('kanka') && !$hasManual)
                        <div class="self-bottom">
                            @if ($user->subscription('kanka')?->onGracePeriod())
                                <a class="btn2 btn-block btn-sm btn-primary " data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', [$tier]) }}">
                                    {{ __('subscriptions/renew.actions.renew') }}
                                </a>
                            @else
                                <a class="btn2 btn-block btn-sm btn-error " data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.unsubscribe') }}">
                                    {{ __('settings.subscription.subscription.actions.cancel') }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @include('settings.subscription.faq')
    </x-grid>
    <input type="hidden" id="stripe-token" value="{{ config('services.stripe.key') }}" />
@endsection

@section('modals')
    @parent

    <x-dialog id="subscribe-confirm" :loading="true" ></x-dialog>
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
