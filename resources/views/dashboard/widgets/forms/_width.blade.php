@php $options = [
    0 => __('dashboard.widgets.widths.0'),
    12 => __('dashboard.widgets.widths.12'),
    3 => __('dashboard.widgets.widths.3'),
    4 => __('dashboard.widgets.widths.4'),
    6 => __('dashboard.widgets.widths.6'),
    8 => __('dashboard.widgets.widths.8'),
    9 => __('dashboard.widgets.widths.9')
];
@endphp
<x-forms.field
    field="width"
    :label="__('dashboard.widgets.fields.width')">
    <x-forms.select name="width" :options="$options" :selected="$source->width ?? $model->width ?? null" />
</x-forms.field>
