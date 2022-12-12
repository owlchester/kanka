<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('settings.subscription.fields.currency') }}</label>
            {!! Form::select('currency', ['' => __('settings.subscription.currencies.usd'), 'eur' => __('settings.subscription.currencies.eur')], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
