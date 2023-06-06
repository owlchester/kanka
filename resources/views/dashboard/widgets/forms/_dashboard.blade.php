<div class="field-dashboard">
    <label>{{ __('dashboard.widgets.fields.dashboard') }}</label>
    {!! Form::select('dashboard_id', $dashboards, (!empty($model) ? $model->dashboard_id : null), ['class' => 'form-control']) !!}
</div>
