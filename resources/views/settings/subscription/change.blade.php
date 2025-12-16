<?php /** @var \App\Models\User $user */ ?>
<x-dialog.header>
    {{ __('subscriptions/confirm.title', ['name' => $tier->name]) }}
</x-dialog.header>

<article class="max-w-xl container p-4 md:px-6">

    <x-grid type="1/1">
    @if ($user->isFrauding())
        <x-alert type="warning">
            {{ __('emails/validation.modal') }}
        </x-alert></div><?php return; ?>
    @endif

    <div class="flex gap-4">
        <div class="flex-none">
            <img class="rounded-full w-fit flex-none" src="{{ $tier->image() }}" alt="{{ $tier->name }}"/>
        </div>
        <div class="text-xl grow">
        @if ($user->hasManualSubscription())
                    You currently have a manual subscription managed by our team. Please contact us at <a href="mailto:{{ config('app.email') }}" class="text-link">{{ config('app.email') }}</a> for assistance.
        @elseif ($user->hasPayPal())
            {!! __('settings.subscription.change.text.upgrade_paypal', [
                'upgrade' => "<strong>$currency" . number_format($upgrade, 2) . "</strong>",
                'tier' => "<strong>$tier->name</strong>",
                'amount' => "<strong>$currency$amount</strong>",
                'date' => $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y')
            ]) !!}
        @else
            {!! __('settings.subscription.change.text.upgrade_' . ($period->isYearly() ? 'yearly' : 'monthly'), [
                'upgrade' => "<strong>$currency<span id='pricing-now'>" . number_format($upgrade, 2) . "</span></strong>",
                'tier' => "<strong>$tier->name</strong>",
                'amount' => "<strong>$currency$amount</strong>"
            ]) !!}
        @endif
        </div>
    </div>

    @if ($user->hasManualSubscription())
        @php return @endphp
    @endif
    <x-alert type="error" :hidden="true"></x-alert>

    <div class="flex flex-col gap-2">
        <select name="select-method" class="select">
            @if (! $limited)
                <option value="card">
                    {{ __('billing/payment_methods.types.card') }}
                </option>
            @endif
            <option value="paypal">
                PayPal
            </option>
        </select>
    </div>

        @if (! $limited)
        <div class="transition-all duration-150" id="card-panel">
            <x-form :action="['settings.subscription.subscribe', 'tier' => $tier]" id="subscription-confirm" direct>

            <x-grid type="1/1" css="text-left">
                @if (!$card)
                    <x-forms.field field="card-name" :label="__('settings.subscription.payment_method.card_name')">
                        <input type="text" name="card-holder-name"  />
                    </x-forms.field>

                    <x-forms.field field="card-number" :label="__('settings.subscription.payment_method.card')">
                        <div id="card-element" class=""></div>
                    </x-forms.field>
                @else
                    <div class="text-center">
                        <strong>{{ __('settings.subscription.fields.payment_method') }}</strong><br />
                        <x-icon class="fa-solid fa-credit-card" /> **** {{ $card->card->last4 }} {{ $card->card->exp_month }}/{{ $card->card->exp_year }}
                        <p><a href="{{ route('billing.payment-method') }}" class="text-link">{{ __('settings.subscription.payment_method.actions.change') }}</a></p>
                    </div>
                    @if ($isDowngrading)

                        <x-helper>
                            <p>{!! __('settings.subscription.upgrade_downgrade.downgrade.provide_reason')!!}</p>
                        </x-helper>

                        <div class="field-reason">
                            <label>{{ __('settings.subscription.fields.reason') }}</label>

                            @php $reasons = [
                                '' => __('crud.select'),
                                'financial' => __('settings.subscription.cancel.options.financial'),
                                'not_using' => __('settings.subscription.cancel.options.not_using'),
                                'missing_features' => __('settings.subscription.cancel.options.missing_features'),
                                'custom' => __('settings.subscription.cancel.options.other')
                            ]; @endphp
                            <div class="flex flex-col gap-2">
                                <x-forms.select name="reason" :options="$reasons" class="w-full select-reveal-field" :extra="['data-change-target' => '#downgrade-reason-custom']" />

                                <textarea name="reason_custom" placeholder="{{ __('settings.subscription.placeholders.downgrade_reason') }}" class="w-full" rows="4" id="downgrade-reason-custom"></textarea>
                            </div>
                        </div>

                    @endif
                @endif

                @includeWhen($hasPromo, 'settings.subscription._promo')
                <div class="text-center">
                    <button class="btn2 btn-block btn-primary subscription-confirm-button">
                        {{ __('subscriptions/confirm.actions.pay', [
    'currency' => $currency,
    'amount' => $amount,
]) }}
                    </button>
                </div>


                <div class="text-neutral-content flex flex-col gap-2 text-left">
                    <div class="flex gap-1">
                        <x-icon class="fa-regular fa-question-circle w-5 flex-none" />
                        <p class="text-xs">
                            @if ($isYearly)
                                {!! __('subscriptions/confirm.helpers.auto-renew.yearly', ['date' => $nextBillingDate->isoFormat('MMMM D, Y')]) !!}
                            @else
                                {!! __('subscriptions/confirm.helpers.auto-renew.monthly', ['date' => $nextBillingDate->isoFormat('MMMM D, Y')]) !!}
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-1">
                        <x-icon class="fa-regular fa-shield w-5 flex-none" />
                        <p class="text-xs">{!! __('settings.subscription.helpers.stripe', ['stripe' => '<a href="https://stripe.com" class="text-link">Stripe</a>']) !!}</p>
                    </div>
                    @if($isYearly)
                        <div class="flex gap-1">
                            <x-icon class="fa-regular fa-handshake w-5 flex-none" />
                            <p class="text-xs grow">
                                {!! __('subscriptions/confirm.helpers.refund', ['email' => '<a href="mailto' . config('app.email') . '" class="text-link">' . config('app.email') . '</a>']) !!}
                            </p>
                        </div>
                    @endif
                </div>
            </x-grid>

            <input type="hidden" name="coupon" id="coupon" value="" />
            <input type="hidden" name="period" value="{{ $period->isYearly() ? 'yearly' : 'monthly' }}" />
            <input type="hidden" name="payment_id" value="{{ $card ? $card->id : null }}" />
            <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
            </x-form>
        </div>
        @endif
        <div class="transition-all duration-150 {{ $limited ? '' : 'hidden' }}" id="paypal-panel">

            <x-grid type="1/1" css="text-left">
            @if (!$period->isYearly())
                <x-alert type="warning">
                    {{ __('settings.subscription.helpers.alternatives_yearly', ['method' => 'PayPal']) }}
                </x-alert>
            @else
                @if ($user->subscribed('kanka') && !$user->hasPayPal())
                    <x-alert type="warning">
                        {{ __('settings.subscription.helpers.alternatives_warning') }}
                    </x-alert>
                @else

                @if ($hasPromo)
                    <x-alert type="warning alert-coupon" hidden class="paypal-coupon">
                        Promotional codes aren't available when subscribing through PayPal.
                    </x-alert>
                @endif

                <x-form :action="['paypal.process-transaction', 'tier' => $tier]" class="subscription-form flex flex-row gap-5">
                    <x-grid type="1/1">
                        <x-helper>
                            <p>{{ __('settings.subscription.helpers.paypal_v3') }}</p>
                        </x-helper>

                        <button class="btn2 btn-block btn-primary subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                            <x-icon class="fa-brands fa-paypal" />
                            {!! __('subscriptions/confirm.actions.paypal', [
'currency' => $currency,
'amount' => $amount,
]) !!}
                        </button>

                        <div class="text-neutral-content flex flex-col gap-2 text-left">
                            <div class="flex gap-1">
                                <x-icon class="fa-regular fa-question-circle w-5 flex-none" />
                                <p class="text-xs">
                                    {!! __('subscriptions/confirm.helpers.auto-renew.none', ['date' => $nextBillingDate->isoFormat('MMMM D, Y')]) !!}
                                </p>
                            </div>
                            <div class="flex gap-1">
                                <x-icon class="fa-regular fa-shield w-5 flex-none" />
                                <p class="text-xs">{!! __('subscriptions/confirm.helpers.paypal') !!}</p>
                            </div>
                            @if($isYearly)
                                <div class="flex gap-1">
                                    <x-icon class="fa-regular fa-handshake w-5 flex-none" />
                                    <p class="text-xs grow">
                                        {!! __('subscriptions/confirm.helpers.refund', ['email' => '<a href="mailto' . config('app.email') . '" class="text-link">' . config('app.email') . '</a>']) !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </x-grid>
                    <input type="hidden" name="coupon" id="coupon" value="" />
                    <input type="hidden" name="period" value="{{ $period->isYearly() ? 'yearly' : 'monthly' }}" />
                    <input type="hidden" name="payment_id" value="{{ $card ? $card->id : null }}" />
                    <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
                </x-form>
                @endif
            @endif
            </x-grid>
        </div>
    </div>
    </x-grid>
</article>
