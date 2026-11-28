<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 * @var ?\App\Models\Campaign $contextCampaign
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
                'more' => '<a href="https://kanka.io/pricing" class="text-link" target="_blank" rel="noopener noreferrer">' . __('subscription.benefits.more') . '</a>',
                'boosters' => '<a href="https://kanka.io/premium" class="text-link" target="_blank" rel="noopener noreferrer">' . __('concept.premium-campaigns') . '</a>',
                'stripe' => '<a href="https://stripe.com" class="text-link" target="_blank" rel="noopener noreferrer">Stripe</a>'
            ]) !!}
        </p>

        @include('partials.errors')

        @if ($user->isSubscriber() || $user->isLegacyPatron() || $hasManual)
            @include('settings.subscription._recap')
        @endif

        @if (!empty($pausedUntil) && $pausedUntil->isFuture())
            <div class="rounded-2xl bg-box p-4 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border border-primary/40">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-base-200 flex items-center justify-center shrink-0 text-primary">
                        <x-icon class="fa-regular fa-pause-circle text-lg" />
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <div class="font-semibold">{{ __('subscriptions/pause.banner.title') }}</div>
                        <p class="text-sm text-neutral-content m-0">
                            {{ __('subscriptions/pause.banner.body', ['date' => $pausedUntil->isoFormat('MMMM D, Y')]) }}
                        </p>
                    </div>
                </div>
                <form method="POST" action="{{ route('settings.subscription.resume') }}" class="shrink-0">
                    @csrf
                    <button type="submit" class="btn2 btn-primary btn-sm">
                        {{ __('subscriptions/pause.actions.resume') }}
                    </button>
                </form>
            </div>
        @elseif (!empty($yearlyNudge))
            <div class="rounded-2xl bg-box p-4 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border border-primary/40">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-base-200 flex items-center justify-center shrink-0 text-primary">
                        <x-icon class="fa-regular fa-calendar-check text-lg" />
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <div class="font-semibold">
                            {{ __('subscriptions/yearly-nudge.card.title', ['savings' => $yearlyNudge['currency_symbol'] . \Illuminate\Support\Number::format($yearlyNudge['savings'], 2)]) }}
                        </div>
                        <p class="text-sm text-neutral-content m-0">
                            {{ __('subscriptions/yearly-nudge.card.body', [
                                'tier' => $yearlyNudge['tier']->name,
                                'savings' => $yearlyNudge['currency_symbol'] . \Illuminate\Support\Number::format($yearlyNudge['savings'], 2),
                            ]) }}
                        </p>
                    </div>
                </div>
                <a
                    href="#"
                    class="btn2 btn-primary btn-sm shrink-0 self-start sm:self-center"
                    data-toggle="dialog"
                    data-target="subscribe-confirm"
                    data-url="{{ route('settings.subscription.change', [$yearlyNudge['tier'], 'period' => 'yearly']) }}"
                >
                    {{ __('subscriptions/yearly-nudge.action') }}
                </a>
            </div>
        @endif

        <h2 class="text-xl m-0">
            {{ __('settings.subscription.tiers') }}
        </h2>

            <p>
                {!! __('tiers.why', ['tiny' => '<a href="' . \App\Facades\Domain::toFront('about') . '" class="text-link" target="_blank" rel="noopener noreferrer">' . __('tiers.tiny') . '</a>']) !!}
            </p>

        @if (!$hasManual)
            <div class="flex flex-wrap items-center justify-center gap-3">
                <div class="grid grid-cols-2 gap-2 rounded-2xl bg-base-200 p-0.5 items-center justify-items-stretch font-bold w-full xl:w-auto border border-base-200">
                    <div class="rounded-2xl px-3 py-2 flex items-center cursor-pointer justify-center text-neutral-content transition-all duration-150" data-period="monthly" role="button">
                        {{ __('tiers.actions.pay.monthly') }}
                    </div>
                    <div class="rounded-2xl px-3 py-2 bg-base-100 flex items-center cursor-pointer justify-center gap-1 transition-all duration-150" data-period="yearly" role="button">
                        <span>{{ __('tiers.actions.pay.yearly') }}</span>
                        <span class="text-primary text-xs">{{ __('tiers.actions.pay.save') }}</span>
                    </div>
                </div>
                @if (!$user->isSubscriber() && !$user->isLegacyPatron())
                    <a href="#" data-toggle="dialog" data-url="{{ route('billing.currency') }}" class="rounded-2xl bg-base-200 px-3 py-2 text-sm font-semibold flex items-center gap-1.5 hover:bg-base-300 transition-colors">
                        <span class="uppercase">{{ $user->currency() }}</span>
                        <x-icon class="fa-solid fa-pencil-alt text-xs" />
                        <span class="sr-only">{{ __('crud.edit') }}</span>
                    </a>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 period-year mx-auto lg:mx-0" id="pricing-overview">
            @php /** @var \App\Models\Tier $tier **/ @endphp
            @foreach ($tiers as $tier)
                @if ($tier->isFree())
                    @continue
                @endif
                @php
                    $monthlyPeriod = \App\Enums\PricingPeriod::Monthly;
                    $yearlyPeriod = \App\Enums\PricingPeriod::Yearly;
                    $monthlyPrice = $tier->activePrice($user->currency(), $monthlyPeriod);
                    $yearlyPrice = $tier->activePrice($user->currency(), $yearlyPeriod);
                    $monthlyGrandfathered = $current?->tier_id === $tier->id
                        && $current->currency === $user->currency()
                        && $current->period === $monthlyPeriod
                        && $monthlyPrice !== null
                        && $current->id !== $monthlyPrice->id;
                    $yearlyGrandfathered = $current?->tier_id === $tier->id
                        && $current->currency === $user->currency()
                        && $current->period === $yearlyPeriod
                        && $yearlyPrice !== null
                        && $current->id !== $yearlyPrice->id;
                    $effectiveYearlyCost = $yearlyGrandfathered ? $current->cost : ($yearlyPrice?->cost ?? 0);
                    $yearlyMonthlyEquivalent = $effectiveYearlyCost / 12;
                @endphp
                <article class="rounded-2xl bg-box flex flex-col gap-4 p-4 relative max-w-2xl lg:max-w-none @if ($tier->isCurrent($user) || (!$user->isSubscriber() && $tier->isWyvern())) border-primary border-2 @endif shadow-xs hover:shadow-md">
                    <div class="flex gap-2 flex-col">
                        <div class="flex justify-between items-start gap-2">
                            <img class="w-16 h-16" src="{{ $tier->image() }}" alt="{{ $tier->name }}"/>
                            @if ($tier->isWyvern())
                                <span class="rounded-full bg-primary text-primary-content text-xs font-semibold px-2.5 py-1">
                                    {{ __('tiers.ribbons.best-value') }}
                                </span>
                            @endif
                        </div>
                        <div class="grow flex flex-col gap-2 w-full">
                            <div class="text-lg font-semibold">
                                {{ $tier->name }}
                            </div>
                            <div class="min-h-14">
                                <div class="price price-monthly flex flex-col gap-1">
                                    <div class="flex gap-2 w-full items-end">
                                        <div class="flex flex-col gap-1">
                                            <div class="text-2xl font-bold">
                                                {{ $user->currencySymbol() }}
                                                {{ \Illuminate\Support\Number::format($monthlyGrandfathered ? $current->cost : $monthlyPrice?->cost ?? 0, 2) }}
                                            </div>
                                        </div>
                                        <span class="text-sm text-neutral-content">{{ __('tiers.periods.billed_monthly') }}</span>
                                    </div>

                                    @if ($monthlyGrandfathered)
                                        <span class="text-xs text-primary font-semibold">{{ __('settings.subscription.plans.grandfathered') }}</span>
                                        <span class="text-xs text-neutral-content">
                                            {{ __('settings.subscription.plans.standard_monthly', ['currency' => \Illuminate\Support\Str::upper($monthlyPrice->currency), 'amount' => \Illuminate\Support\Number::format($monthlyPrice->cost, 2)]) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="price price-yearly flex flex-col gap-1 w-full">
                                    <div class="flex gap-2 w-full items-end">
                                        <div class="flex flex-col gap-1">
                                            <div class="text-2xl font-bold">
                                                {{ $user->currencySymbol() }}
                                                {{ \Illuminate\Support\Number::format($yearlyMonthlyEquivalent, 2) }}
                                            </div>
                                        </div>
                                        <span class="text-sm text-neutral-content">{{ __('tiers.periods.per_month') }}</span>
                                    </div>
                                    <div class="text-xs text-neutral-content">
                                        {{ __('tiers.periods.billed_yearly_amount', ['currency' => $user->currencySymbol(), 'amount' => \Illuminate\Support\Number::format($effectiveYearlyCost, 2)]) }}
                                    </div>

                                    @if ($yearlyGrandfathered)
                                        <span class="text-xs text-primary font-semibold">{{ __('settings.subscription.plans.grandfathered') }}</span>
                                        <span class="text-xs text-neutral-content">
                                            {{ __('settings.subscription.plans.standard_yearly', ['currency' => \Illuminate\Support\Str::upper($yearlyPrice->currency), 'amount' => \Illuminate\Support\Number::format($yearlyPrice->cost, 2)]) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if ($tier->code === 'owlbear')
                                <p class="text-sm text-neutral-content lg:min-h-12">{{ __('tiers.target.owlbear') }}</p>
                            @elseif ($tier->isWyvern())
                                <p class="text-sm text-neutral-content lg:min-h-12">{{ __('tiers.target.wyvern') }}</p>
                            @elseif ($tier->code === 'elemental')
                                <p class="text-sm text-neutral-content lg:min-h-12">{{ __('tiers.target.elemental') }}</p>
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
                    @if ($tier->isCurrent($user) && $user->subscribed('kanka') && !$hasManual && !$user->hasPayPal())
                        <div class="mt-auto pt-2">
                            @if ($user->subscription('kanka')?->onGracePeriod())
                                <a class="btn2 btn-block btn-sm btn-primary" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', [$tier]) }}">
                                    {{ __('subscriptions/renew.actions.renew') }}
                                </a>
                            @else
                                <a class="btn2 btn-block btn-sm btn-error" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.unsubscribe') }}">
                                    {{ __('settings.subscription.subscription.actions.cancel') }}
                                </a>
                            @endif
                        </div>
                    @endif
                </article>
            @endforeach
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-sm text-neutral-content">
            <div class="flex items-center gap-2 rounded-xl bg-box px-3 py-2.5 shadow-xs">
                <x-icon class="fa-regular fa-handshake text-primary shrink-0" />
                <span>{{ __('tiers.reassurance.refund') }}</span>
            </div>
            <div class="flex items-center gap-2 rounded-xl bg-box px-3 py-2.5 shadow-xs">
                <x-icon class="fa-regular fa-arrows-rotate text-primary shrink-0" />
                <span>{{ __('tiers.reassurance.cancel') }}</span>
            </div>
            <div class="flex items-center gap-2 rounded-xl bg-box px-3 py-2.5 shadow-xs">
                <x-icon class="fa-regular fa-shield text-primary shrink-0" />
                <span>{{ __('tiers.reassurance.data') }}</span>
            </div>
            <div class="flex items-center gap-2 rounded-xl bg-box px-3 py-2.5 shadow-xs">
                <x-icon class="fa-regular fa-users text-primary shrink-0" />
                <span>{{ __('tiers.reassurance.shared') }}</span>
            </div>
        </div>

        <div class="rounded-2xl bg-box p-5 lg:p-6 shadow-xs flex flex-col gap-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-base-200 flex items-center justify-center shrink-0">
                        <x-icon class="fa-regular fa-gem text-boost text-lg" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold m-0">{{ __('tiers.premium_summary.title') }}</h3>
                        <p class="text-sm text-neutral-content m-0">
                            @if ($contextCampaign && intval($contextCampaign->members_count) > 1)
                                {{ __('tiers.premium_summary.subtitle_group', ['campaign' => $contextCampaign->name, 'count' => intval($contextCampaign->members_count)]) }}
                            @elseif ($contextCampaign)
                                {{ __('tiers.premium_summary.subtitle_solo', ['campaign' => $contextCampaign->name, 'storage' => config('limits.gallery.premium') / 1024 / 1024]) }}
                            @else
                                {{ __('tiers.premium_summary.subtitle') }}
                            @endif
                        </p>
                    </div>
                </div>
                <a href="https://kanka.io/premium" class="btn2 btn-sm shrink-0 self-start sm:self-center inline-flex items-center gap-1.5" target="_blank" rel="noopener noreferrer">
                    {{ __('tiers.premium_summary.more') }}
                    <x-icon class="fa-regular fa-external-link text-xs" />
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="rounded-xl bg-base-200/60 p-3.5 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-base-100 flex items-center justify-center shrink-0 text-boost">
                        <x-icon class="fa-regular fa-palette" />
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <div class="text-sm font-semibold">{{ __('tiers.premium_summary.plugins_title') }}</div>
                        <div class="text-xs text-neutral-content">{{ __('tiers.premium_summary.plugins_desc') }}</div>
                    </div>
                </div>
                <div class="rounded-xl bg-base-200/60 p-3.5 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-base-100 flex items-center justify-center shrink-0 text-boost">
                        <x-icon class="fa-regular fa-map" />
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <div class="text-sm font-semibold">{{ __('tiers.premium_summary.maps_title') }}</div>
                        <div class="text-xs text-neutral-content">{{ __('tiers.premium_summary.maps_desc') }}</div>
                    </div>
                </div>
                <div class="rounded-xl bg-base-200/60 p-3.5 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-base-100 flex items-center justify-center shrink-0 text-boost">
                        <x-icon class="fa-regular fa-layer-group" />
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <div class="text-sm font-semibold">{{ __('tiers.premium_summary.structure_title') }}</div>
                        <div class="text-xs text-neutral-content">{{ __('tiers.premium_summary.structure_desc') }}</div>
                    </div>
                </div>
                <div class="rounded-xl bg-base-200/60 p-3.5 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-base-100 flex items-center justify-center shrink-0 text-boost">
                        <x-icon class="fa-regular fa-users" />
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <div class="text-sm font-semibold">{{ __('tiers.premium_summary.sharing_title') }}</div>
                        <div class="text-xs text-neutral-content">{{ __('tiers.premium_summary.sharing_desc', ['days' => config('limits.campaigns.logs.premium')]) }}</div>
                    </div>
                </div>
            </div>
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
