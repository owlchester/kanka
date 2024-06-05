@php $options = [
    'h1' => 'H1',
    'h2' => 'H2',
    null => 'H3',
    'h4' => 'H4',
    'h5' => 'H5',
    'h6' => 'H6',
];
@endphp
<x-forms.field
    field="size"
    :label="__('dashboard.widgets.fields.size')">
    <x-forms.select name="config[size]" :options="$options" :selected="$source->config['size'] ?? $model->config['size'] ?? null" />
</x-forms.field>
