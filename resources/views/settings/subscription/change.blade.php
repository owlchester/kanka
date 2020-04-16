{!! Form::open(['route' => ['settings.subscription.subscribe'], 'method' => 'POST', 'id' => 'subscription-confirm']) !!}
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
        <h4>{!! __('settings.subscription.change.text', ['tier' => "<strong>$tier</strong>", 'amount' => "<strong>$amount</strong>"]) !!}</h4>
    @else
        <h4>{!! __('settings.subscription.actions.cancel_sub') !!}</h4>
    @endif

    <div class="alert alert-danger" style="display: none"></div>

    @if (!$cancel)
        <div class="card">
        @if (!$card)
            <label>{{ __('settings.subscription.payment_method.card_name' )}}</label>
            {!! Form::text('card-holder-name', null, ['class' => 'form-control']) !!}

            <label>{{ __('settings.subscription.payment_method.card' )}}</label>
            <div id="card-element">

            </div>
        @else
            <div class="text-center">
                <strong>{{ __('settings.subscription.fields.payment_method') }}</strong><br />
                <i class="fas fa-credit-card"></i> **** {{ $card->card->last4 }} {{ $card->card->exp_month }}/{{ $card->card->exp_year }}

                <p><a href="{{ route('settings.billing') }}">{{ __('settings.subscription.payment_method.actions.change') }}</a></p>
            </div>
        @endif
    @else
        <p class="help-block">
            {!! __('settings.subscription.cancel.text')!!}
        </p>

        <div class="form-group">
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
    @endif
    </div>
</div>
<div class="box-footer">

    <div class="text-center">
        @if ($cancel)

            <button class="btn btn-xl btn-danger" id="subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
                {{ __('settings.subscription.actions.cancel_sub') }}
            </button>
        @else
        <button class="btn btn-xl btn-success" id="subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
            {{ __('settings.subscription.actions.subscribe') }}
        </button>
        @endif
    </div>
</div>

<input type="hidden" name="tier" value="{{ $tier }}" />
<input type="hidden" name="payment_id" value="{{ $card ? $card->id : null }}" />
<input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
{!! Form::close() !!}
