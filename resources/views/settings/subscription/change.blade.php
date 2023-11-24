<x-dialog.header>
    {{ __('settings.subscription.change.title') }}
</x-dialog.header>

<article class="text-center max-w-xl container">

    <x-grid type="1/1">
    @if ($user->isFrauding())
        <x-alert type="warning">
            {{ __('settings.subscription.errors.failed', ['email' => config('app.email')]) }}
        </x-alert></div><?php return; ?>
    @endif

    @if (!$cancel)
            <h4>
        @if ($user->hasPayPal())
            {!! __('settings.subscription.change.text.upgrade_paypal', [
                'upgrade' => "<strong>$currency$upgrade</strong>",
                'tier' => "<strong>$tier</strong>",
                'amount' => "<strong>$currency$amount</strong>",
                'date' => $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y')
            ]) !!}
        @else
            {!! __('settings.subscription.change.text.upgrade_' . $period, [
                'upgrade' => "<strong>$currency<span id='pricing-now'>$upgrade</span></strong>",
                'tier' => "<strong>$tier</strong>",
                'amount' => "<strong>$currency$amount</strong>"
            ]) !!}
        @endif
            </h4>
    @else
        <h4>{!! __('settings.subscription.actions.cancel_sub') !!}</h4>
    @endif

    <x-alert type="error" :hidden="true"></x-alert>

    @if (!$cancel)
        @if ($hasPromo)
            @if ($isYearly)
            <div class="field text-left">
                <label>{{ __('settings.subscription.coupon.label') }}</label>
                    <input type="text" name="coupon-check" maxlength="12" id="coupon-check" class="w-full" data-url="{{ route('subscription.check-coupon', ['tier' => $tier]) }}" />
            </div>
            <div id="coupon-validating" class="p-2 text-center hidden">
                <x-icon class="loading" />
            </div>
            <x-alert type="success" :hidden="true" id="coupon-success"></x-alert>
            <x-alert type="warning" :hidden="true" id="coupon-invalid">
                {{ __('settings.subscription.coupon.invalid') }}
            </x-alert>
            @else
              <x-alert type="success">
                  Psst! Our yearly subscriptions are 20% of during black friday!
              </x-alert>
            @endif
        @endif
        <div class="card" style="margin: 0">
            <ul class="nav-tabs bg-base-300 !p-1 rounded " role="tablist">
                @if (! $limited)
                <li role="presentation" class="active">
                    <a href="#card" aria-controls="home" role="tab" data-toggle="tab">
                        <x-icon class="fa-regular fa-credit-card"></x-icon>
                        {{ __('billing/payment_methods.types.card') }}
                    </a>
                </li>
                <li role="presentation">
                    <a href="#sofort" aria-controls="profile" role="tab" data-toggle="tab">
                        Sofort
                        </a>
                </li>
                <li role="presentation">
                    <a href="#giropay" aria-controls="settings" role="tab" data-toggle="tab">
                        giropay
                    </a>
                </li>
                @endif
                <li role="presentation" @if ($limited) class="active" @endif>
                    <a href="#paypal" aria-controls="settings" role="tab" data-toggle="tab">
                        <i class="fa-brands fa-paypal" aria-hidden="true"></i>
                        PayPal
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content bg-base-100 p-4 rounded-bl rounded-br">
                @if (! $limited)
                <div role="tabpanel" class="tab-pane active" id="card">
                    {!! Form::open(['route' => ['settings.subscription.subscribe'], 'method' => 'POST', 'id' => 'subscription-confirm']) !!}

                    <x-grid type="1/1" css="text-left">
                    @if (!$card)
                        <x-forms.field field="card-name" :label="__('settings.subscription.payment_method.card_name')">
                            {!! Form::text('card-holder-name', null, ['class' => '']) !!}
                        </x-forms.field>

                        <x-forms.field field="card-number" :label="__('settings.subscription.payment_method.card')">
                            <div id="card-element" class=""></div>
                        </x-forms.field>
                    @else
                        <div class="text-center">
                            <strong>{{ __('settings.subscription.fields.payment_method') }}</strong><br />
                            <i class="fa-solid fa-credit-card"></i> **** {{ $card->card->last4 }} {{ $card->card->exp_month }}/{{ $card->card->exp_year }}
                            <p><a href="{{ route('billing.payment-method') }}">{{ __('settings.subscription.payment_method.actions.change') }}</a></p>
                        </div>
                        @if ($isDowngrading)

                            <p class="help-block">
                                {!! __('settings.subscription.upgrade_downgrade.downgrade.provide_reason')!!}
                            </p>

                            <div class="ffield-reason">
                                <label>{{ __('settings.subscription.fields.reason') }}</label>
                                {!! Form::select('reason', [
                                    '' => __('crud.select'),
                                    'financial' => __('settings.subscription.cancel.options.financial'),
                                    'not_using' => __('settings.subscription.cancel.options.not_using'),
                                    'missing_features' => __('settings.subscription.cancel.options.missing_features'),
                                    'custom' => __('settings.subscription.cancel.options.custom')
                                ], null, ['class' => 'w-full select-reveal-field', 'data-change-target' => '#downgrade-reason-custom']) !!}
                                {!! Form::textarea(
                                    'reason_custom',
                                    null,
                                    [
                                        'placeholder' => __('settings.subscription.placeholders.downgrade_reason'),
                                        'class' => '',
                                        'style' => 'display: none',
                                        'rows' => 4,
                                        'id' => 'downgrade-reason-custom'
                                    ]
                                )!!}
                            </div>

                        @endif
                    @endif
                    <div class="text-center">
                        <button class="btn2 btn-lg btn-primary subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                            <span>{{ __('settings.subscription.actions.subscribe') }}</span>
                            <i class="fa-solid fa-spin fa-spinner spinner" style="display: none"></i>
                        </button>
                    </div>
                    </x-grid>

                    <input type="hidden" name="tier" value="{{ $tier }}" />
                    <input type="hidden" name="coupon" id="coupon" value="" />
                    <input type="hidden" name="period" value="{{ $period }}" />
                    <input type="hidden" name="payment_id" value="{{ $card ? $card->id : null }}" />
                    <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
                    {!! Form::close() !!}
                </div>
                <div role="tabpanel" class="tab-pane" id="sofort">
                    <x-grid type="1/1" css="text-left">
                        <p class="help-block">
                            {{ __('settings.subscription.helpers.alternatives', ['method' => 'SOFORT']) }}
                        </p>
                        @if ($hasPromo)
                            <x-alert type="warning" class="alert-coupon">Sadly we cannot offer discounts for Sofort payments.</x-alert>
                        @endif

                        @if ($period !== 'yearly')
                            <x-alert type="warning">
                                {{ __('settings.subscription.helpers.alternatives_yearly', ['method' => 'SOFORT']) }}
                            </x-alert>
                        @else
                            @if ($user->subscribed('kanka'))
                                <x-alert type="warning">
                                    {{ __('settings.subscription.helpers.alternatives_warning') }}
                                </x-alert>
                            @else
                            {!! Form::open(['route' => ['settings.subscription.alt-subscribe'], 'method' => 'POST', 'class' => 'subscription-form']) !!}
                            <x-forms.field css="mb-5" field="sofort-country" :label="__('settings.subscription.payment_method.country')">
                                <select id="sofort-country"  name="sofort-country" class="w-full">
                                    <option value="">{{ __('crud.select') }}</option>
                                    <option value="at">{{ __('settings.countries.austria') }}</option>
                                    <option value="be">{{ __('settings.countries.belgium') }}</option>
                                    <option value="de">{{ __('settings.countries.germany') }}</option>
                                    <option value="it">{{ __('settings.countries.italy') }}</option>
                                    <option value="nl">{{ __('settings.countries.netherlands') }}</option>
                                    <option value="es">{{ __('settings.countries.spain') }}</option>
                                </select>
                            </x-forms.field>

                            <div class="text-center">
                                <button class="btn2 btn-lg btn-primary subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                                    <span>{{ __('settings.subscription.actions.subscribe') }}</span>
                                    <i class="fa-solid fa-spin fa-spinner spinner" style="display: none"></i>
                                </button>
                            </div>

                            <input type="hidden" name="method" value="sofort" />
                            <input type="hidden" name="tier" value="{{ $tier }}" />
                            <input type="hidden" name="period" value="{{ $period }}" />
                            <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
                            {!! Form::close() !!}
                            @endif
                        @endif
                    </x-grid>
                </div>
                <div role="tabpanel" class="tab-pane" id="giropay">
                    <x-grid type="1/1" css="text-left">
                        <p class="help-block">
                            {{ __('settings.subscription.helpers.alternatives', ['method' => 'Giropay']) }}
                        </p>
                        @if ($hasPromo)
                            <x-alert type="warning alert-coupon">
                                Sadly we cannot offer discounts for giropay payments.
                            </x-alert>
                        @endif

                        @if ($period !== 'yearly')
                            <x-alert type="warning">
                                {{ __('settings.subscription.helpers.alternatives_yearly', ['method' => 'Giropay']) }}
                            </x-alert>
                        @else
                            @if ($user->subscribed('kanka'))
                                <x-alert type="warning">
                                    {{ __('settings.subscription.helpers.alternatives_warning') }}
                                </x-alert>
                            @else
                            {!! Form::open(['route' => ['settings.subscription.alt-subscribe'], 'method' => 'POST', 'class' => 'subscription-form']) !!}
                            <x-forms.field css="mb-5" field="accountholder-name" :label="__('settings.subscription.payment_method.card_name')">
                                <input id="accountholder-name"  name="accountholder-name" class="w-full">
                            </x-forms.field>

                            <div class="text-center">
                                <button class="btn2 btn-lg btn-primary subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                                    <span>{{ __('settings.subscription.actions.subscribe') }}</span>
                                    <i class="fa-solid fa-spin fa-spinner spinner" style="display: none"></i>
                                </button>
                            </div>

                            <input type="hidden" name="method" value="giropay" />
                            <input type="hidden" name="tier" value="{{ $tier }}" />
                            <input type="hidden" name="period" value="{{ $period }}" />
                            <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
                            {!! Form::close() !!}
                            @endif
                        @endif
                    </x-grid>
                </div>
                @endif
                <div role="tabpanel" class="tab-pane {{ $limited ? 'active' : null }}" id="paypal">

                    <x-grid type="1/1" css="text-left">
                    <p class="help-block">
                        {{ __('settings.subscription.helpers.alternatives-2', ['method' => 'PayPal']) }}
                    </p>
                    @if ($period !== 'yearly')
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
                            <x-alert type="warning alert-coupon">
                                Sadly we currently don't support promotions on PayPal subscriptions.
                            </x-alert>
                        @endif

                        {!! Form::open(['route' => ['paypal.process-transaction'], 'method' => 'POST', 'class' => 'subscription-form flex flex-row gap-5']) !!}
                            <p class="help-block">
                                {{ __('settings.subscription.helpers.paypal_v3') }}
                            </p>
                            <div class="text-center">
                                <button class="btn2 btn-lg btn-primary subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                                    <span>{{ __('settings.subscription.actions.subscribe') }}</span>
                                    <i class="fa-solid fa-spin fa-spinner spinner" style="display: none"></i>
                                </button>
                            </div>
                            <input type="hidden" name="tier" value="{{ $tier }}" />
                            <input type="hidden" name="coupon" id="coupon" value="" />
                            <input type="hidden" name="period" value="{{ $period }}" />
                            <input type="hidden" name="payment_id" value="{{ $card ? $card->id : null }}" />
                            <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
                        {!! Form::close() !!}
                        @endif
                    @endif
                    </x-grid>
                </div>
            </div>
        </div>

            <p class="help-block">
                {!! __('settings.subscription.helpers.stripe', ['stripe' => link_to('https://stripe.com', 'Stripe', ['target' => '_blank'])]) !!}
        @if($isYearly)
                <br />{!! __('settings.subscription.trial_period', ['email' => link_to('mailto:' .  config('app.email'), config('app.email'))]) !!}
        @endif
            </p>
    @else
        @include('settings.subscription._cancel')
    @endif
    </div></x-grid>
</article>
