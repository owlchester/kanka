<x-forms.field field="dashboard" :label="__('dashboard.widgets.fields.dashboard')">
    {!! Form::select('dashboard_id', $dashboards, (!empty($model) ? $model->dashboard_id : null), ['class' => 'form-control']) !!}
</x-forms.field>
