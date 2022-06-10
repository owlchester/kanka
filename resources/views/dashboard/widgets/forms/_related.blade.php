
<div class="">
    {!! Form::hidden('config[attributes]', 0) !!}
    <div class="form-group checkbox">
        <label>
            {!! Form::checkbox('config[attributes]', 1, (!empty($model) ? $model->conf('attributes') : null), ['id' => 'config-attributes', 'disabled' => !$boosted ? 'disabled' : null]) !!}
            {{ __('dashboard.widgets.recent.show_attributes') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.show_attributes') }}"></i>
        </label>
    </div>
    <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.show_attributes') }}</p>
</div>

<div class="">
    {!! Form::hidden('config[relations]', 0) !!}
    <div class="form-group checkbox">
        <label>
            {!! Form::checkbox('config[relations]', 1, (!empty($model) ? $model->conf('relations') : null), ['id' => 'config-relations', 'disabled' => !$boosted ? 'disabled' : null]) !!}
            {{ __('dashboard.widgets.recent.show_relations') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.show_relations') }}"></i>
        </label>
    </div>
    <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.show_relations') }}</p>
</div>

<div class="">
    {!! Form::hidden('config[members]', 0) !!}
    <div class="form-group checkbox">
        <label>
            {!! Form::checkbox('config[members]', 1, (!empty($model) ? $model->conf('members') : null), ['id' => 'config-members', 'disabled' => !$boosted ? 'disabled' : null]) !!}
            {{ __('dashboard.widgets.recent.show_members') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.show_members') }}"></i>
        </label>
    </div>
    <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.show_members') }}</p>
</div>
