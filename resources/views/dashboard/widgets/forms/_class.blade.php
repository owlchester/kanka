<div class="field-class">
    <label for="config[class]">
        {{ __('dashboard.widgets.fields.class') }}
        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" data-title="{{ __('dashboard.widgets.helpers.class') }}" aria-hidden="true"></i>
    </label>
    {!! Form::text('config[class]', null, ['class' => 'form-control', 'id' => 'config[class]', 'disabled' => !$boosted ? 'disabled' : null]) !!}
    <p class="help-block visible-xs visible-sm">
        {{ __('dashboard.widgets.helpers.class') }}
    </p>
</div>
