<?php /**
 * @var \App\Models\User $user
 * @var \App\Models\TierPrice $current
 * */?>
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
$box = 'rounded-2xl p-2 lg:p-3 bg-box shadow-xs hover:shadow flex flex-col items-center justify-center gap-2';

@endphp

<div class="grid grid-flow-row-dense grid-cols-1 sm:grid-cols-2 {{ $colClass }} gap-2 lg:gap-4">
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
                @if ($user->hasPayPal() || $user->hasManualSubscription())
                    {{ $user->pledge }}
                @else
                {{ $current->tier->name ?? \App\Models\Pledge::KOBOLD }}
                @endif
            </div>
            <div class="text-muted">
                {{ __('settings.subscription.fields.plan') }}
            </div>
        </div>
        @if (!$user->hasPayPal())
        <div class="{{ $box }}">
            <div class="text-xl text-center">
                @if (!empty($current))
                    @if ($current->isYearly())
                        {{ __('settings.subscription.plans.cost_yearly', ['amount' => number_format($current->cost, 2), 'currency' => \Illuminate\Support\Str::upper($current->currency)]) }}
                    @else
                        {{ __('settings.subscription.plans.cost_monthly', ['amount' => number_format($current->cost, 2), 'currency' => \Illuminate\Support\Str::upper($current->currency)]) }}
                    @endif
                @else
                    {{ __('front.pricing.tier.free') }}
                @endif
            </div>
            <div class="text-muted">
                {{ __('settings.subscription.fields.billing') }}
            </div>
        </div>
        @endif
        <a class="{{ $box }}" href="#" data-toggle="dialog"
           data-target="primary-dialog" data-url="{{ route('billing.currency') }}">
            <div class="text-xl text-center">
                <span class="uppercase">{{ $user->currency() }}</span>
                <x-icon class="fa-solid fa-pencil-alt" />
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

    @if ($user->hasDefaultPaymentMethod())
        <div class="{{ $box }}">
            <div class="text-xl text-center">
                @php $method = $user->defaultPaymentMethod(); @endphp
                {{ __('settings.subscription.payment_method.saved', ['brand' => ucfirst($method->card?->brand), 'last4' => $method->card?->last4]) }}
            </div>
            <div class="text-muted">
                {{ __('settings.subscription.fields.payment_method') }}
            </div>
        </div>
    @else
        <a href="{{ route('billing.payment-method') }}" class="{{ $box }}">
            <div class="text-xl text-center">
                {{ __('settings.subscription.payment_method.actions.add' ) }}
                <x-icon class="fa-solid fa-credit-card" />
            </div>

            <div class="text-muted">
                {{ __('settings.subscription.fields.payment_method') }}
            </div>
        </a>
    @endif
</div>
