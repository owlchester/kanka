@php
$monthlyKey = 'settings.subscription.subscription.actions.subscribe';
$yearlyKey = 'settings.subscription.subscription.actions.subscribe_annual';
if (isset($toggle) && $toggle) {
    $monthlyKey = 'tiers.actions.subscribe.monthly';
    $yearlyKey = 'tiers.actions.subscribe.yearly';
}
@endphp

<div class="flex flex-col gap-2 col-span-2">
</div>
<div class="flex flex-col gap-2">
    @if ($user->subscription('kanka')->stripe_price != 'paypal_Wyvern' && $user->subscription('kanka')->stripe_price != 'paypal_Elemental')
        <a class="btn2 btn-block btn-sm btn-primary" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::WYVERN, 'period' => 'yearly']) }}">
            {{ __($yearlyKey, ['tier' => 'Wyvern']) }}
        </a>
    @elseif ($user->subscription('kanka')->stripe_price == 'paypal_Wyvern')
        <a class="btn2 btn-block btn-sm disabled">
            {{ __('tiers.current') }}
        </a>
    @endif

</div>
<div class="flex flex-col gap-2">
    @if ($user->subscription('kanka')->stripe_price != 'paypal_Elemental')
        <a class="btn2 btn-block btn-sm btn-primary" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::ELEMENTAL, 'period' => 'yearly']) }}">
            {{ __($yearlyKey, ['tier' => 'Elemental']) }}
        </a>
    @else
        <a class="btn2 btn-block btn-sm disabled ">
            {{ __('tiers.current') }}
        </a>
    @endif
</div>
