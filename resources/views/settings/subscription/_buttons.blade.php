@if ($status == \App\Services\SubscriptionService::STATUS_GRACE)
    <div class="col-span-4">
        <p class="help-block">
            {{ __('settings.subscription.cancelled', ['date' => auth()->user()->subscription('kanka')->ends_at->isoFormat('lll')]) }}
        </p>
    </div>
    <?php return; ?>
@endif

@php
$monthlyKey = 'settings.subscription.subscription.actions.subscribe';
$yearlyKey = 'settings.subscription.subscription.actions.subscribe_annual';
if (isset($toggle) && $toggle) {
    $monthlyKey = 'tiers.actions.subscribe.monthly';
    $yearlyKey = 'tiers.actions.subscribe.yearly';
}
@endphp

<div class="flex flex-col gap-2">
    @if($currentPlan === \App\Models\Pledge::KOBOLD)
        <a class="btn2 btn-block btn-sm disabled">
            {{ __('tiers.current') }}
        </a>
    @else
        <a class="btn2 btn-block btn-sm " data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::KOBOLD]) }}">
            {{ __('settings.subscription.subscription.actions.cancel') }}<br />
            ({{ __('settings.subscription.subscription.actions.rollback') }})
        </a>
    @endif
</div>
<div class="flex flex-col gap-2">
    @if ($user->subscribedToPrice($service->elementalPlans(), 'kanka'))
        <a class="btn2 btn-block btn-sm disabled">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @else
        @if($user->subscribedToPrice([config('subscription.owlbear.eur.monthly'), config('subscription.owlbear.usd.monthly')], 'kanka'))
            <a class="btn2 btn-block btn-sm disabled">
                {{ __('tiers.current') }}
            </a>
        @else
            <a class="btn2 btn-block btn-sm btn-primary price-monthly" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::OWLBEAR, 'period' => 'monthly']) }}">
                {{ __($monthlyKey, ['tier' => 'Owlbear']) }}
            </a>
        @endif

        @if($user->subscribedToPrice([config('subscription.owlbear.eur.yearly'), config('subscription.owlbear.usd.yearly')], 'kanka'))
            <a class="btn2 btn-block btn-sm disabled price-yearly">
                {{ __('tiers.current') }}
            </a>
        @else
            <a class="btn2 btn-block btn-sm btn-primary price-yearly" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::OWLBEAR, 'period' => 'yearly']) }}">
                {{ __($yearlyKey, ['tier' => 'Owlbear']) }}
            </a>
        @endif
    @endif
</div>
<div class="flex flex-col gap-2">
    @if($user->subscribedToPrice([config('subscription.wyvern.eur.monthly'), config('subscription.wyvern.usd.monthly')], 'kanka'))
        <a class="btn2 btn-block btn-sm disabled">
            {{ __('tiers.current') }}
        </a>
    @elseif ($user->subscribedToPrice($service->wyvernPlans(), 'kanka'))
        <a class="btn2 btn-block btn-sm disabled">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @else
        <a class="btn2 btn-block btn-sm btn-primary price-monthly" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::WYVERN, 'period' => 'monthly']) }}">
            {{ __($monthlyKey, ['tier' => 'Wyvern']) }}
        </a>
    @endif


    @if($user->subscribedToPrice([config('subscription.wyvern.eur.yearly'), config('subscription.wyvern.usd.yearly')], 'kanka'))
        <a class="btn2 btn-block btn-sm disabled">
            {{ __('tiers.current') }}
        </a>
    @else
        <a class="btn2 btn-block btn-sm btn-primary price-yearly" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::WYVERN, 'period' => 'yearly']) }}">
            {{ __($yearlyKey, ['tier' => 'Wyvern']) }}
        </a>
    @endif
</div>
<div class="flex flex-col gap-2">
    @if($user->subscribedToPrice([config('subscription.elemental.eur.monthly'), config('subscription.elemental.usd.monthly')], 'kanka'))
        <a class="btn2 btn-block btn-sm disabled">
            {{ __('tiers.current') }}
        </a>
    @elseif ($user->subscribedToPrice($service->elementalPlans(), 'kanka'))
        <a class="btn2 btn-block btn-sm disabled">
            {{ __('settings.subscription.subscription.actions.downgrading') }}
        </a>
    @else
        <a class="btn2 btn-block btn-sm btn-primary price-monthly" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::ELEMENTAL, 'period' => 'monthly']) }}">
            {{ __($monthlyKey, ['tier' => 'Elemental']) }}
        </a>
    @endif

    @if($user->subscribedToPrice([config('subscription.elemental.eur.yearly'), config('subscription.elemental.usd.yearly')], 'kanka'))
        <a class="btn2 btn-block btn-sm disabled price-yearly">
            {{ __('tiers.current') }}
        </a>
    @else
        <a class="btn2 btn-block btn-sm btn-primary price-yearly" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Pledge::ELEMENTAL, 'period' => 'yearly']) }}">
            {{ __($yearlyKey, ['tier' => 'Elemental']) }}
        </a>
    @endif
</div>