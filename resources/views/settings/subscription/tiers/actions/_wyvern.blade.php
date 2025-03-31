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
    @if($user->subscribedToPrice($tier->monthlyPlans(), 'kanka'))
        <a class="btn2 btn-block disabled">
            {{ __('tiers.current') }}
        </a>
    @elseif ($user->subscribedToPrice($tier->plans(), 'kanka'))
        <a class="btn2 btn-block disabled">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @else
        <a class="btn2 btn-block btn-primary price-monthly" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => $tier, 'period' => 'monthly']) }}">
            {{ __('tiers.actions.subscribe.choose', ['tier' => $tier->name]) }}
        </a>
    @endif


    @if($user->subscribedToPrice($tier->yearlyPlans(), 'kanka'))
        <a class="btn2 btn-block disabled">
            {{ __('tiers.current') }}
        </a>
    @else
        <a class="btn2 btn-block btn-primary price-yearly" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => $tier, 'period' => 'yearly']) }}">
            {{ __('tiers.actions.subscribe.choose', ['tier' => $tier->name]) }}
        </a>
    @endif
@endif
