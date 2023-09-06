@php
$monthlyKey = 'settings.subscription.subscription.actions.subscribe';
$yearlyKey = 'settings.subscription.subscription.actions.subscribe_annual';
if (isset($toggle) && $toggle) {
    $monthlyKey = 'tiers.actions.subscribe.monthly';
    $yearlyKey = 'tiers.actions.subscribe.yearly';
}
@endphp

<div class="flex flex-col gap-2">
    <a class="btn2 btn-block btn-sm disabled">
        {{ __('settings.subscription.subscription.actions.downgrading') }}
    </a>
</div>
<div class="flex flex-col gap-2">
    @if (str_contains($user->subscriptions()->first()->stripe_price, 'paypal'))
        <a class="btn2 btn-block btn-sm disabled">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @endif
</div>
<div class="flex flex-col gap-2">
    @if ($user->subscriptions()->first()->stripe_price == 'paypal_Wyvern')
        <a class="btn2 btn-block btn-sm disabled price-monthly">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @elseif ($user->subscriptions()->first()->stripe_price == 'paypal_Elemental')
        <a class="btn2 btn-block btn-sm disabled price-monthly">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @else
        <a class="btn2 btn-block btn-sm disabled price-monthly">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @endif
    @if ($user->subscriptions()->first()->stripe_price != 'paypal_Wyvern' && $user->subscriptions()->first()->stripe_price != 'paypal_Elemental')
        <a class="btn2 btn-block btn-sm btn-primary price-yearly" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::WYVERN, 'period' => 'yearly']) }}">
            {{ __($yearlyKey, ['tier' => 'Wyvern']) }}
        </a>
    @elseif ($user->subscriptions()->first()->stripe_price == 'paypal_Wyvern')
        <a class="btn2 btn-block btn-sm disabled price-yearly">
            {{ __('tiers.current') }}
        </a>
    @else ($user->subscriptions()->first()->stripe_price == 'paypal_Elemental')
        <a class="btn2 btn-block btn-sm disabled price-yearly">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @endif

</div>
<div class="flex flex-col gap-2">
    @if ($user->subscriptions()->first()->stripe_price == 'paypal_Elemental')
        <a class="btn2 btn-block btn-sm disabled price-monthly">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @else
        <a class="btn2 btn-block btn-sm disabled price-monthly">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @endif
    @if ($user->subscriptions()->first()->stripe_price != 'paypal_Elemental')
        <a class="btn2 btn-block btn-sm btn-primary price-yearly" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::ELEMENTAL, 'period' => 'yearly']) }}">
            {{ __($yearlyKey, ['tier' => 'Elemental']) }}
        </a>
    @else
        <a class="btn2 btn-block btn-sm disabled price-yearly">
            {{ __('tiers.current') }}
        </a>
    @endif
</div>
