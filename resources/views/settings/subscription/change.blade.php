

<div class="modal-body">
    @include('partials.modals.close')
    <div class="quick-creator-header mt-8 pb-4 mb-4">
        <div class="text-2xl">
            {{ __('settings.subscription.change.title') }}
        </div>
    </div>

    @if ($user->isFrauding())
        <x-alert type="warning">
            {{ __('settings.subscription.errors.failed', ['email' => config('app.email')]) }}
        </x-alert></div><?php return; ?>
    @endif

    @if (!$cancel)
        <h4>{!! __('settings.subscription.change.text.' . $period, ['tier' => "<strong>$tier</strong>", 'amount' => "<strong>$amount</strong>"]) !!}</h4>
    @else
        <h4>{!! __('settings.subscription.actions.cancel_sub') !!}</h4>
    @endif

    <x-alert type="error" :hidden="true"></x-alert>


    @if (!$cancel)
        @if ($hasPromo)
            <label>{{ __('settings.subscription.coupon.label') }}</label>
            <div class="join mb-5">
                <input type="text" name="coupon-check" maxlength="12" id="coupon-check" class="form-control join-item" data-url="{{ route('subscription.check-coupon') }}" />

                <button type="button" id="coupon-check-btn" class="btn2 btn-primary btn-outline join-item" data-title="{{ __('settings.subscription.coupon.check') }}" data-toggle="tooltip">
                    <i class="fa-solid fa-check check"></i>
                    <i class="fa-solid fa-spinner fa-spin spinner" style="display: none"></i>
                </button>
            </div>
            <x-alert type="success" :hidden="true" id="coupon-success"></x-alert>
            <x-alert type="warning" :hidden="true" id="coupon-invalid">
                {{ __('settings.subscription.coupon.invalid') }}
            </x-alert>
        @endif
        <div class="card" style="margin: 0">

            <ul class="nav-tabs bg-base-300 !p-1 rounded" role="tablist">
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

                    @if (!$card)
                        <div class="field-card-name mb-5">
                            <label>{{ __('settings.subscription.payment_method.card_name' )}}</label>
                            {!! Form::text('card-holder-name', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="field-card-number">
                            <label>{{ __('settings.subscription.payment_method.card' )}}</label>
                            <div id="card-element" class="mb-5">
                        </div>

                        </div>
                    @else
                        <div class="text-center mb-5">
                            <strong>{{ __('settings.subscription.fields.payment_method') }}</strong><br />
                            <i class="fa-solid fa-credit-card"></i> **** {{ $card->card->last4 }} {{ $card->card->exp_month }}/{{ $card->card->exp_year }}
                            <p><a href="{{ route('billing.payment-method') }}">{{ __('settings.subscription.payment_method.actions.change') }}</a></p>
                        </div>
                        @if ($isDowngrading)

                            <p class="help-block">
                                {!! __('settings.subscription.upgrade_downgrade.downgrade.provide_reason')!!}
                            </p>

                            <div class="ffield-reason mb-5">
                                <label>{{ __('settings.subscription.fields.reason') }}</label>
                                {!! Form::select('reason', [
                                    '' => __('crud.select'),
                                    'financial' => __('settings.subscription.cancel.options.financial'),
                                    'not_using' => __('settings.subscription.cancel.options.not_using'),
                                    'missing_features' => __('settings.subscription.cancel.options.missing_features'),
                                    'custom' => __('settings.subscription.cancel.options.custom')
                                ], null, ['class' => 'form-control mb-5 select-reveal-field', 'data-change-target' => '#downgrade-reason-custom']) !!}
                                {!! Form::textarea(
                                    'reason_custom',
                                    null,
                                    [
                                        'placeholder' => __('settings.subscription.placeholders.downgrade_reason'),
                                        'class' => 'form-control',
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

                    <input type="hidden" name="tier" value="{{ $tier }}" />
                    <input type="hidden" name="coupon" id="coupon" value="" />
                    <input type="hidden" name="period" value="{{ $period }}" />
                    <input type="hidden" name="payment_id" value="{{ $card ? $card->id : null }}" />
                    <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
                    {!! Form::close() !!}
                </div>
                <div role="tabpanel" class="tab-pane" id="sofort">
                    <p class="help-block">
                        {{ __('settings.subscription.helpers.alternatives', ['method' => 'SOFORT']) }}
                    </p>
                    @if ($hasPromo)
                        <x-alert type="error" class="alert-coupon">Sadly we cannot offer discounts for Sofort payments.</x-alert>
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
                        <label for="sofort-country">
                            {{ __('settings.subscription.payment_method.country') }}
                        </label>
                        <select id="sofort-country"  name="sofort-country" class="form-control mb-5">
                            <option value="">{{ __('crud.select') }}</option>
                            <option value="at">{{ __('settings.countries.austria') }}</option>
                            <option value="be">{{ __('settings.countries.belgium') }}</option>
                            <option value="de">{{ __('settings.countries.germany') }}</option>
                            <option value="it">{{ __('settings.countries.italy') }}</option>
                            <option value="nl">{{ __('settings.countries.netherlands') }}</option>
                            <option value="es">{{ __('settings.countries.spain') }}</option>
                        </select>

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

                </div>
                <div role="tabpanel" class="tab-pane" id="giropay">
                    <p class="help-block">
                        {{ __('settings.subscription.helpers.alternatives', ['method' => 'Giropay']) }}
                    </p>
                    @if ($hasPromo)
                        <x-alert type="error alert-coupon">
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
                        <label for="accountholder-name">
                            {{ __('settings.subscription.payment_method.card_name') }}
                        </label>
                        <input id="accountholder-name"  name="accountholder-name" class="form-control mb-5">

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
                </div>
                @endif
                <div role="tabpanel" class="tab-pane {{ $limited ? 'active' : null }}" id="paypal">
                    <p class="help-block">
                        {{ __('settings.subscription.helpers.alternatives-2', ['method' => 'PayPal']) }}
                    </p>
                    @if ($period !== 'yearly')
                        <x-alert type="warning">
                            {{ __('settings.subscription.helpers.alternatives_yearly', ['method' => 'PayPal']) }}
                        </x-alert>
                    @elseif (config('paypal.enabled'))

                        @if ($user->subscribed('kanka'))
                            <x-alert type="warning">
                                {{ __('settings.subscription.helpers.alternatives_warning') }}
                            </x-alert>
                        @else
                        {!! Form::open(['route' => ['paypal.process-transaction'], 'method' => 'POST', 'class' => 'subscription-form']) !!}
                            <p class="help-block">
                                {!! __('settings.subscription.helpers.paypal_v3', ['email' => link_to('mailto:' . config('app.email'), config('app.email'))]) !!}
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
                    @else
                        <p>Send us an email at {{ config('app.email') }} to get a yearly subscription through PayPal.</p>
                    @endif
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
    </div>
</div>
