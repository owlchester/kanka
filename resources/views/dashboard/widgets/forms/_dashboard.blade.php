<x-forms.field field="dashboard" :label="__('dashboard.widgets.fields.dashboard')">
    <x-forms.select
        name="dashboard_id"
        :options="['' => __('dashboard.dashboards.default.title')] + $dashboards"
        :selected="$source->dashboard_id ?? $model->dashboard_id ?? (isset($dashboard) ? $dashboard->id : null)"
    />
</x-forms.field>
