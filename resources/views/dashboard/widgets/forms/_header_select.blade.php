{!! Form::hidden('config[entity-header]', 0) !!}
<div class="field-header checkbox">
    <label>
        {!! Form::checkbox('config[entity-header]', 1, (!empty($model) ? $model->conf('entity-header') : null), ['id' => 'config-entity-header', 'disabled' => !$boosted ? 'disabled' : null]) !!}
        {{ __('dashboard.widgets.recent.entity-header') }}

        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" data-title="{{ __('dashboard.widgets.recent.helpers.entity-header') }}" aria-hidden="true"></i>
    </label>
    <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.entity-header') }}</p>
</div>
