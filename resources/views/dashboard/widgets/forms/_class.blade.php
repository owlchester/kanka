<div class="field-class">
    <label for="config[class]">
        {{ __('dashboard.widgets.fields.class') }}
        <x-helpers.tooltip :title="__('dashboard.widgets.helpers.class')" />
    </label>
    {!! Form::text('config[class]', null, ['class' => 'form-control', 'id' => 'config[class]', 'disabled' => !$boosted ? 'disabled' : null]) !!}
    <p class="help-block visible-xs visible-sm">
        {{ __('dashboard.widgets.helpers.class') }}
    </p>
</div>
