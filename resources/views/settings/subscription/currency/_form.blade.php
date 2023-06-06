<div class="field-currency">
    <label>{{ __('settings.subscription.fields.currency') }}</label>
    {!! Form::select('currency', ['' => __('settings.subscription.currencies.usd'), 'eur' => __('settings.subscription.currencies.eur')], null, ['class' => 'form-control']) !!}
</div>
