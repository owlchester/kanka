<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ __('dashboard.widgets.fields.dashboard') }}</label>
            {!! Form::select('dashboard_id', $dashboards, (!empty($model) ? $model->dashboard_id : null), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
