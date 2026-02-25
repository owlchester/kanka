@php
    $displayOptions = [
        0 => __('dashboard.widgets.preview.displays.expand'),
        1 => __('dashboard.widgets.preview.displays.full'),
        2 => __('entries/tabs.properties'),
    ];
@endphp
<x-forms.field
    field="display"
    :label="__('dashboard.widgets.preview.fields.display')">
    <x-forms.select name="config[full]" :options="$displayOptions" :selected="$source->config['full'] ?? $model->config['full'] ?? null" />
</x-forms.field>
