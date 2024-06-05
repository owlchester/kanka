<x-forms.field field="dashboard" :label="__('dashboard.widgets.fields.dashboard')">
    <x-forms.select name="dashboard_id" :options="$dashboards" :selected="$source->dashboard_id ?? $model->dashboard_id ?? null" />
</x-forms.field>
