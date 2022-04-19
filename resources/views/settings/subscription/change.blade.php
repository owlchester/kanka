<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="newEntityModalLabel">
        {{ __('settings.subscription.change.title') }}
    </h4>
</div>
<div class="modal-body">
    @if (!$cancel)
        <h4>{!! __('settings.subscription.change.text.' . $period, ['tier' => "<strong>$tier</strong>", 'amount' => "<strong>$amount</strong>"]) !!}</h4>
    @else
        <h4>{!! __('settings.subscription.actions.cancel_sub') !!}</h4>
    @endif

    <div class="alert alert-danger" style="display: none"></div>


    @if (!$cancel)
        @if ($period == 'yearly' && \Carbon\Carbon::create(2021, 11, 1)->isFuture())
            <label>{{ __('settings.subscription.coupon.label') }}</label>
            <div class="input-group margin-bottom">
                <input type="text" name="coupon-check" maxlength="12" id="coupon-check" class="form-control" data-url="{{ route('subscription.check-coupon') }}" />

                <span class="input-group-btn">
                  <button type="button" id="coupon-check-btn" class="btn btn-info btn-flat" title="{{ __('settings.subscription.coupon.check') }}" data-toggle="tooltip">
                      <i class="fas fa-check"></i>
                  </button>
                </span>
            </div>
            <p class="alert alert-success" style="display:none" id="coupon-success"></p>
            <p class="alert alert-warning" style="display:none" id="coupon-invalid">
                {{ __('settings.subscription.coupon.invalid') }}
            </p>
        @endif
        <div class="card" style="margin: 0">

        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#card" aria-controls="home" role="tab" data-toggle="tab">Card</a></li>
                <li role="presentation"><a href="#sofort" aria-controls="profile" role="tab" data-toggle="tab">Sofort</a></li>
                <li role="presentation"><a href="#giropay" aria-controls="settings" role="tab" data-toggle="tab">giropay</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="card">
                    {!! Form::open(['route' => ['settings.subscription.subscribe'], 'method' => 'POST', 'id' => 'subscription-confirm']) !!}
                    @if (!$card)
                        <label>{{ __('settings.subscription.payment_method.card_name' )}}</label>
                        {!! Form::text('card-holder-name', null, ['class' => 'form-control']) !!}

                        <label>{{ __('settings.subscription.payment_method.card' )}}</label>

                        <div id="card-element" class="margin-bottom">

                        </div>
                    @else
                        <div class="text-center margin-bottom">
                            <strong>{{ __('settings.subscription.fields.payment_method') }}</strong><br />
                            <i class="fas fa-credit-card"></i> **** {{ $card->card->last4 }} {{ $card->card->exp_month }}/{{ $card->card->exp_year }}

                            <p><a href="{{ route('settings.billing') }}">{{ __('settings.subscription.payment_method.actions.change') }}</a></p>
                        </div>
                    @endif



                    <div class="text-center">
                        <button class="btn btn-lg btn-primary subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                            {{ __('settings.subscription.actions.subscribe') }}
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

                    @if ($period !== 'yearly')
                        <p class="text-danger">
                            {{ __('settings.subscription.helpers.alternatives_yearly', ['method' => 'SOFORT']) }}
                        </p>
                    @else
                        @if ($user->subscribed('kanka'))
                            <p class="alert alert-warning">
                                {{ __('settings.subscription.helpers.alternatives_warning') }}
                            </p>
                        @else
                        {!! Form::open(['route' => ['settings.subscription.alt-subscribe'], 'method' => 'POST', 'class' => 'subscription-form']) !!}
                        <label for="sofort-country">
                            {{ __('settings.subscription.payment_method.country') }}
                        </label>
                        <select id="sofort-country"  name="sofort-country" class="form-control margin-bottom">
                            <option value="">{{ __('crud.select') }}</option>
                            <option value="at">{{ __('settings.countries.austria') }}</option>
                            <option value="be">{{ __('settings.countries.belgium') }}</option>
                            <option value="de">{{ __('settings.countries.germany') }}</option>
                            <option value="it">{{ __('settings.countries.italy') }}</option>
                            <option value="nl">{{ __('settings.countries.netherlands') }}</option>
                            <option value="es">{{ __('settings.countries.spain') }}</option>
                        </select>

                        <div class="text-center">
                            <button class="btn btn-lg btn-primary subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                                {{ __('settings.subscription.actions.subscribe') }}
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

                    @if ($period !== 'yearly')
                        <p class="text-danger">
                            {{ __('settings.subscription.helpers.alternatives_yearly', ['method' => 'Giropay']) }}
                        </p>
                    @else
                        @if ($user->subscribed('kanka'))
                            <p class="alert alert-warning">
                                {{ __('settings.subscription.helpers.alternatives_warning') }}
                            </p>
                        @else
                        {!! Form::open(['route' => ['settings.subscription.alt-subscribe'], 'method' => 'POST', 'class' => 'subscription-form']) !!}
                        <label for="accountholder-name">
                            {{ __('settings.subscription.payment_method.card_name') }}
                        </label>
                        <input id="accountholder-name"  name="accountholder-name" class="form-control margin-bottom">

                        <div class="text-center">
                            <button class="btn btn-xl btn-success subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                                {{ __('settings.subscription.actions.subscribe') }}
                            </button>
                        </div>

                        <input type="hidden" name="method" value="giropay" />
                        <input type="hidden" name="tier" value="{{ $tier }}" />
                        <input type="hidden" name="period" value="{{ $period }}" />
                        <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
                        {!! Form::close() !!}

                        @if($period === 'yearly')
                            <p class="help-block">
                                {!! __('settings.subscription.trial_period', ['email' => link_to('mailto:' .  config('app.email'), config('app.email'))]) !!}
                            </p>
                        @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>

            <p class="help-block">
                {!! __('settings.subscription.helpers.stripe', ['stripe' => link_to('https://stripe.com', 'Stripe', ['target' => '_blank'])]) !!}
        @if($period === 'yearly')
                <br />{!! __('settings.subscription.trial_period', ['email' => link_to('mailto:' .  config('app.email'), config('app.email'))]) !!}
        @endif
            </p>
    @else
        {!! Form::open(['route' => ['settings.subscription.subscribe'], 'method' => 'POST', 'id' => 'cancellation-confirm', 'class' => 'subscription-form']) !!}

        <p class="help-block">
            {!! __('settings.subscription.cancel.text')!!}
        </p>

        <div class="form-group margin-bottom">
            <label>{{ __('settings.subscription.fields.reason') }}</label>
            {!! Form::select('reason', [
    '' => __('crud.select'),
    'financial' => __('settings.subscription.cancel.options.financial'),
    'not_using' => __('settings.subscription.cancel.options.not_using'),
    'missing_features' => __('settings.subscription.cancel.options.missing_features'),
    'competitor' => __('settings.subscription.cancel.options.competitor'),
    'custom' => __('settings.subscription.cancel.options.custom')
], null, ['class' => 'form-control margin-bottom', 'id' => 'cancel-reason-select']) !!}
            {!! Form::textarea(
                'reason_custom',
                null,
                [
                    'placeholder' => __('settings.subscription.placeholders.reason'),
                    'class' => 'form-control',
                    'style' => 'display: none',
                    'rows' => 4,
                    'id' => 'cancel-reason-custom'
                ]
            ) !!}
        </div>

        <div class="text-center">
            <button class="btn btn-lg btn-danger subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                {{ __('settings.subscription.actions.cancel_sub') }}
            </button>
        </div>

        <input type="hidden" name="tier" value="{{ $tier }}" />
        <input type="hidden" name="period" value="{{ $period }}" />
        <input type="hidden" name="payment_id" value="{{ $card ? $card->id : null }}" />
        <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
        <input type="hidden" name="is_downgrade" value="true" />
        {!! Form::close() !!}
    @endif
    </div>
</div>
