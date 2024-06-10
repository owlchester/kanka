@php
    $default = isset($fieldname) ? [null => ''] : [];
    $iconOptions = [
        1 => __('maps/markers.icons.marker'),
        2 => __('maps/markers.icons.question'),
        3 => __('maps/markers.icons.exclamation'),
        4 => __('maps/markers.icons.entity'),
    ];
    $iconOptions = $default + $iconOptions;
@endphp
<x-forms.field
    field="icon"
    :label="__('maps/markers.fields.icon')">
    <x-forms.select :name="$fieldname ?? 'icon'" :options="$iconOptions" :selected="$source->icon ?? $model->icon ?? null" id="icon" />
</x-forms.field>
