<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
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
        <h1 class="text-2xl">{{ __('settings.subscription.manage_subscription') }}</h1>

        <p class="">
            {!! __('subscription.benefits.main', [
                'more' => '<a href="https://kanka.io/pricing" class="text-link">' . __('subscription.benefits.more') . '</a>',
                'boosters' => '<a href="https://kanka.io/premium" class="text-link">' . __('concept.premium-campaigns') . '</a>',
                'stripe' => '<a href="https://stripe.com" class="text-link">Stripe</a>'
            ]) !!}
        </p>

        @include('partials.errors')

        @include('settings.subscription._recap')

        <h2 class="text-xl m-0">
            {{ __('settings.subscription.tiers') }}
        </h2>
        @if (!$isPayPal && !$hasManual)
            <div class="flex justify-center">
                <div class="grid grid-cols-2 gap-2 rounded-2xl bg-base-200 p-0.5 items-center justify-items-stretch font-bold w-full xl:w-auto">
                    <div class="rounded-2xl px-3 py-2 bg-base-100 flex items-center cursor-pointer justify-center transition-all duration-150" data-period="monthly" role="button">
                        {{ __('tiers.actions.pay.monthly') }}
                    </div>
                    <div class="rounded-2xl px-3 py-2 flex items-center cursor-pointer justify-center text-neutral-content gap-1 transition-all duration-150" data-period="yearly" role="button">
                        <span>{{ __('tiers.actions.pay.yearly') }}</span>
                        <span class="text-primary text-xs">{{ __('tiers.actions.pay.save') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 @if ($user->isSubscriber()) lg:grid-cols-3 @else md:grid-cols-2 xl:grid-cols-4 @endif gap-4 @if ($isPayPal || $hasManual) period-year @else period-month @endif mx-auto lg:mx-0" id="pricing-overview">
            @php /** @var \App\Models\Tier $tier **/ @endphp
            @foreach ($tiers as $tier)
                @if ($tier->isFree() && $user->isSubscriber())
                    @continue
                @endif
                <article class="rounded-2xl bg-box flex flex-col gap-4 p-4 relative max-w-2xl lg:max-w-none @if ($tier->isCurrent($user)) border-primary border @elseif ($tier->isWyvern()) border-accent border md:py-6 @else md:my-2 @endif shadow-xs hover:shadow-md ">
                    <div class="flex gap-2 flex-col ">
                        <div class="flex justify-between gap-2">
                            <img class="w-16 h-16 " src="{{ $tier->image() }}" alt="{{ $tier->name }}"/>

                            @if ($tier->isCurrent($user))
                            @elseif ($tier->isBestValue())
                                <div>
                                    <div class="bg-accent text-accent-content text-sm rounded-full px-3 py-1.5">
                                        🏆 {{ __('tiers.ribbons.best-value') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="grow flex flex-col gap-2 w-full">
                            <div class="text-lg">
                                {{ $tier->name }}
                            </div>
                            @if ($tier->isFree())
                                <div class="price text-neutral-content">
                                    {{ __('front.features.patreon.free') }}
                                </div>
                            @else
                                <div class="price price-monthly flex gap-2 w-full items-end">
                                    <div class="text-2xl">
                                        {{ $user->currencySymbol() }}
                                        {{ number_format($tier->price($user->currency(), \App\Enums\PricingPeriod::Monthly), 2) }}
                                    </div>
                                    <span class="text-sm text-neutral-content ">{{ __('tiers.periods.billed_monthly') }}</span>
                                </div>
                                <div class="price price-yearly flex gap-2 w-full items-end">
                                    <div class="text-2xl">
                                        {{ $user->currencySymbol() }}
                                        {{ number_format($tier->price($user->currency(), \App\Enums\PricingPeriod::Yearly), 2) }}
                                    </div>
                                    <span class="text-sm text-neutral-content ">{{ __('tiers.periods.billed_yearly') }}</span>
                                </div>
                            @endif

                            @if ($tier->code === 'owlbear')
                                <p class="">{{ __('tiers.target.owlbear') }}</p>
                            @elseif ($tier->isWyvern())
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
                </article>
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

    @if (!$user->isSubscriber())
        <script>
            gtag('event', 'view_item_list', {
                item_list_id: 'pricing_tiers',
                item_list_name: '{{ __('settings.subscription.manage_subscription') }}'
            });
        </script>
    @endif
@endsection

@section('styles')
    @vite('resources/css/subscription.css')
@endsection
