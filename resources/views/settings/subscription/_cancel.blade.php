<?php /** @var \App\User $user */ ?>
@php
    $endDate = date($user->date_format, $user->upcomingInvoice()?->period_end);
@endphp
{!! Form::open([
    'route' => ['settings.subscription.subscribe'],
    'method' => 'POST',
    'id' => 'cancellation-confirm',
    'class' => 'subscription-form'
]) !!}
<p class="help-block">
    {!! __('settings.subscription.cancel.text', ['date' => $endDate])!!}
</p>

<div class="field-cancel-reason mb-5">
    <label>{{ __('settings.subscription.fields.reason') }}</label>
    {!! Form::select('reason', [
'' => __('crud.select'),
'financial' => __('settings.subscription.cancel.options.financial'),
'not_for' => __('settings.subscription.cancel.options.not_for'),
'not_using' => __('settings.subscription.cancel.options.not_using'),
'not_playing' => __('settings.subscription.cancel.options.not_playing'),
'missing_features' => __('settings.subscription.cancel.options.missing_features'),
'competitor' => __('settings.subscription.cancel.options.competitor'),
'custom' => __('settings.subscription.cancel.options.other')
], null, ['class' => 'form-control mb-5']) !!}
    {!! Form::textarea(
        'reason_custom',
        null,
        [
            'placeholder' => __('settings.subscription.placeholders.reason'),
            'class' => 'form-control',
            'rows' => 4,
            'id' => 'cancel-reason-custom'
        ]
    ) !!}
</div>

<div class="text-center">
    <button class="btn btn-lg btn-danger subscription-confirm-button" data-text="{{ __('settings.subscription.actions.subscribe') }}">
        <span>{{ __('settings.subscription.actions.cancel_sub') }}</span>
        <i class="fa-solid fa-spin fa-spinner spinner" style="display: none"></i>
    </button>
</div>

<input type="hidden" name="tier" value="{{ $tier }}" />
<input type="hidden" name="period" value="{{ $period }}" />
<input type="hidden" name="payment_id" value="{{ $card ? $card->id : null }}" />
<input type="hidden" name="subscription-intent-token" value="{{ $intent->client_secret }}" />
<input type="hidden" name="is_downgrade" value="true" />
{!! Form::close() !!}
