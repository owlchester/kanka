<?php /** @var \App\Models\User $user */ ?>
<x-dialog.header>
    {{ __('settings.subscription.change.title') }}
</x-dialog.header>

<article class="text-center max-w-xl container">

    <x-grid type="1/1">
    @if ($user->isFrauding())
        <x-alert type="warning">
            {{ __('emails/validation.modal') }}
        </x-alert></div><?php return; ?>
    @endif

    <h4>
        @if ($user->hasManualSubscription())
                    You currently have a manual subscription managed by our team. Please contact us at <a href="mailto:{{ config('app.email') }}">{{ config('app.email') }}</a> for assistance.
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
    </h4>

    @if ($user->hasManualSubscription())
        @php return @endphp
    @endif
    <x-alert type="error" :hidden="true"></x-alert>

    @includeWhen($hasPromo, 'settings.subscription._promo')
    <div class="card m-0">
        <ul class="nav-tabs bg-base-300 !p-1 rounded " role="tablist">
            @if (! $limited)
            <li role="presentation" class="active">
                <a href="#card" aria-controls="home" role="tab" data-toggle="tab">
                    <x-icon class="fa-regular fa-credit-card" />
                    {{ __('billing/payment_methods.types.card') }}
                </a>
            </li>
            @endif
            <li role="presentation" @if ($limited) class="active" @endif>
                <a href="#paypal" aria-controls="settings" role="tab" data-toggle="tab">
                    <x-icon class="fa-brands fa-paypal" />
                    PayPal
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content bg-base-100 p-4 rounded-bl rounded-br">
            @if (! $limited)
            <div role="tabpanel" class="tab-pane active" id="card">
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
                        <p><a href="{{ route('billing.payment-method') }}">{{ __('settings.subscription.payment_method.actions.change') }}</a></p>
                    </div>
                    @if ($isDowngrading)

                        <p class="help-block">
                            {!! __('settings.subscription.upgrade_downgrade.downgrade.provide_reason')!!}
                        </p>

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
                <div class="text-center">
                    <button class="btn2 btn-lg btn-primary subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                        {{ __('settings.subscription.actions.subscribe') }}
                    </button>
                </div>
                </x-grid>

                <input type="hidden" name="coupon" id="coupon" value="" />
                <input type="hidden" name="period" value="{{ $period->isYearly() ? 'yearly' : 'monthly' }}" />
                <input type="hidden" name="payment_id" value="{{ $card ? $card->id : null }}" />
                <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
                </x-form>
            </div>
            @endif
            <div role="tabpanel" class="tab-pane {{ $limited ? 'active' : null }}" id="paypal">

                <x-grid type="1/1" css="text-left">
                <p class="help-block">
                    {{ __('settings.subscription.helpers.alternatives-2', ['method' => 'PayPal']) }}
                </p>
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
                        <p class="help-block">
                            {{ __('settings.subscription.helpers.paypal_v3') }}
                        </p>
                        <div class="text-center">
                            <button class="btn2 btn-lg btn-primary subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                                {{ __('settings.subscription.actions.subscribe') }}
                            </button>
                        </div>
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
    </div>

        <p class="help-block">
            {!! __('settings.subscription.helpers.stripe', ['stripe' => '<a href="https://stripe.com" target="_blank">Stripe</a>']) !!}
    @if($isYearly)
            <br />{!! __('settings.subscription.trial_period', ['email' => '<a href="mailto' . config('app.email') . '">' . config('app.email') . '</a>']) !!}
    @endif
        </p>
    </div></x-grid>
</article>
