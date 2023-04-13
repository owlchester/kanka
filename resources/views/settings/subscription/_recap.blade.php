@php
$cols = 1;
$colClass = 'lg:grid-cols-1';
if ($user->isLegacyPatron()) {
    $cols = 3;
    $colClass = 'lg:grid-cols-3';
} else {
    $colClass = 'lg:grid-cols-4';
    $cols = 4;
    if ($user->subscribed('kanka')) {
        $colClass = 'lg:grid-cols-5';
        $cols = 5;
        if ($status == \App\Services\SubscriptionService::STATUS_GRACE) {
            $cols = 6;
            $colClass = 'lg:grid-cols-6';
        }
    }
}
$box = 'rounded p-2 lg:p-3 bg-box shadow-xs flex flex-col items-center justify-center gap-2';

@endphp

<div class="grid grid-flow-row-dense grid-cols-1 sm:grid-cols-2 {{ $colClass }} gap-2 lg:gap-4 mb-10">
    @if ($user->isLegacyPatron())
        <div class="{{ $box }}">
            <div class="text-xl text-center">
                {{ empty($user->pledge) ? 'Kobold' : $user->pledge }}
            </div>
            <div class="text-muted">
                {{ __('settings.subscription.fields.plan') }}
            </div>
        </div>
        <div class="{{ $box }}">
            <div class="text-xl text-center">
                Patreon
            </div>
            <div class="text-muted">
                {{ __('settings.subscription.fields.billing') }}
            </div>
        </div>
    @else
        <div class="{{ $box }}">
            <div class="text-xl  text-center">
                {{ $currentPlan }}
            </div>
            <div class="text-muted">
                {{ __('settings.subscription.fields.plan') }}
            </div>
        </div>
        <div class="{{ $box }}">
            <div class="text-xl text-center">
                @if ($user->subscribedToPrice($service->yearlyPlans(\App\Models\Pledge::OWLBEAR), 'kanka'))
                    {{ __('settings.subscription.plans.cost_yearly', ['amount' => 55.00, 'currency' => $currency]) }}
                @elseif ($user->subscribedToPrice($service->monthlyPlans(\App\Models\Pledge::OWLBEAR), 'kanka'))
                    {{ __('settings.subscription.plans.cost_monthly', ['amount' => 5.00, 'currency' => $currency]) }}
                @elseif ($user->subscribedToPrice($service->yearlyPlans(\App\Models\Pledge::WYVERN), 'kanka'))
                    {{ __('settings.subscription.plans.cost_yearly', ['amount' => 110.00, 'currency' => $currency]) }}
                @elseif ($user->subscribedToPrice($service->monthlyPlans(\App\Models\Pledge::WYVERN), 'kanka'))
                    {{ __('settings.subscription.plans.cost_monthly', ['amount' => 10.00, 'currency' => $currency]) }}
                @elseif ($user->subscribedToPrice($service->yearlyPlans(\App\Models\Pledge::ELEMENTAL), 'kanka'))
                    {{ __('settings.subscription.plans.cost_yearly', ['amount' => 275.00, 'currency' => $currency]) }}
                @elseif ($user->subscribedToPrice($service->monthlyPlans(\App\Models\Pledge::ELEMENTAL), 'kanka'))
                    {{ __('settings.subscription.plans.cost_monthly', ['amount' => 25.00, 'currency' => $currency]) }}
                @else
                    {{ __('front.pricing.tier.free') }}
                @endif
            </div>
            <div class="text-muted">
                {{ __('settings.subscription.fields.billing') }}
            </div>
        </div>
        <a class="{{ $box }}" href="#" data-toggle="modal"
           data-target="#change-currency">
            <div class="text-xl text-center">
                {{ $user->billedInEur() ? 'EUR' : 'USD' }}
                <i class="fa-solid fa-pencil-alt" aria-hidden="true"></i>
                <span class="sr-only">{{ __('crud.edit') }}</span>
            </div>
            <div class="text-muted">
                {{ __('settings.subscription.fields.currency') }}
            </div>
        </a>
        @if ($user->subscribed('kanka'))
            <div class="{{ $box }}">
                <div class="text-xl text-center">
                    {{ $user->subscription('kanka')->created_at->isoFormat('MMMM D, Y') }}
                </div>
                <div class="text-muted">
                    {{ __('settings.subscription.fields.active_since') }}
                </div>
            </div>
            @if ($status == \App\Services\SubscriptionService::STATUS_GRACE)
                <div class="{{ $box }}">
                    <div class="text-xl text-center">
                        {{ $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y') }}
                    </div>
                    <div class="text-muted">
                        {{ __('settings.subscription.fields.active_until') }}
                    </div>
                </div>
            @endif
        @endif
    @endif

    @if ($user->hasPaymentMethod())
        <div class="{{ $box }}">
            <div class="text-xl text-center">
                @php $method = $user->defaultPaymentMethod(); @endphp
                {{ __('settings.subscription.payment_method.saved', ['brand' => ucfirst($method->card->brand), 'last4' => $method->card->last4]) }}
            </div>
            <div class="text-muted">
                {{ __('settings.subscription.fields.payment_method') }}
            </div>
        </div>
    @else
        <a href="{{ route('billing.payment-method') }}" class="{{ $box }}">
            <div class="text-xl text-center">
                {{ __('settings.subscription.payment_method.actions.add' ) }}
                <i class="fa-solid fa-credit-card" aria-hidden="true"></i>
            </div>

            <div class="text-muted">
                {{ __('settings.subscription.fields.payment_method') }}
            </div>
        </a>
    @endif
</div>
