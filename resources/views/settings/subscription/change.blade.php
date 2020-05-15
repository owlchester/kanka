<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.click_modal.close') }}">
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
        <div class="card">

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
                        <button class="btn btn-xl btn-success subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                            {{ __('settings.subscription.actions.subscribe') }}
                        </button>
                    </div>

                    <input type="hidden" name="tier" value="{{ $tier }}" />
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
                            <button class="btn btn-xl btn-success subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
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
                        @endif
                    @endif
                </div>
            </div>
    @else
        {!! Form::open(['route' => ['settings.subscription.subscribe'], 'method' => 'POST', 'id' => 'subscription-confirm']) !!}

        <p class="help-block">
            {!! __('settings.subscription.cancel.text')!!}
        </p>

        <div class="form-group margin-bottom">
            <label>{{ __('settings.subscription.fields.reason') }}</label>
            {!! Form::textarea(
                'reason',
                null,
                [
                    'placeholder' => __('settings.subscription.placeholders.reason'),
                    'class' => 'form-control',
                    'rows' => 4,
                ]
            ) !!}
        </div>

        <div class="text-center">
            <button class="btn btn-xl btn-danger subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                {{ __('settings.subscription.actions.cancel_sub') }}
            </button>
        </div>


        <input type="hidden" name="tier" value="{{ $tier }}" />
        <input type="hidden" name="period" value="{{ $period }}" />
        <input type="hidden" name="payment_id" value="{{ $card ? $card->id : null }}" />
        <input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
        {!! Form::close() !!}
    @endif
    </div>
</div>
