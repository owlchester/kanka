@php
/**
 * @var \App\Models\User $user
 * @var \App\Models\Tier $tier
 */
@endphp
@if ($user->hasPayPal())
    @if (!$user->isWyvern() && !$user->isElemental())
        <a class="btn2 btn-block btn-primary" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => $tier, 'period' => 'yearly']) }}">
            {{ __('tiers.actions.subscribe.choose', ['tier' => $tier->name]) }}
        </a>
    @endif
@else
    @if ($user->isElemental())
        <a class="btn2 btn-block disabled">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @else
        @if($user->subscribedToPrice($tier->monthlyPlans(), 'kanka'))
            <a class="btn2 btn-block disabled price-monthly">
                {{ __('tiers.current') }}
            </a>
        @else
            <a
                class="btn2 btn-block btn-primary price-monthly"
                data-toggle="dialog"
                data-target="subscribe-confirm"
                data-url="{{ route('settings.subscription.change', ['tier' => $tier, 'period' => 'monthly']) }}"
                data-id="{{ $tier->code . '-monthly' }}"
                data-name="{{ $tier->name }} Monthly"
                data-price="{{ $tier->price($user->currency(), \App\Enums\PricingPeriod::Monthly) }}"
            >
                {{ __('tiers.actions.subscribe.choose', ['tier' => $tier->name]) }}
            </a>
        @endif

        @if($user->subscribedToPrice($tier->yearlyPlans(), 'kanka'))
            <a class="btn2 btn-block disabled price-yearly">
                {{ __('tiers.current') }}
            </a>
        @else
            <a
                class="btn2 btn-block btn-primary price-yearly"
                data-toggle="dialog"
                data-target="subscribe-confirm"
                data-url="{{ route('settings.subscription.change', ['tier' => $tier, 'period' => 'yearly']) }}"
                data-id="{{ $tier->code . '-yearly' }}"
                data-name="{{ $tier->name }} Yearly"
                data-price="{{ $tier->price($user->currency(), \App\Enums\PricingPeriod::Yearly) }}"
            >
                {{ __('tiers.actions.subscribe.choose', ['tier' => $tier->name]) }}
            </a>
        @endif
    @endif
@endif
