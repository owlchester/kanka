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
    {!! Form::select($fieldname ?? 'icon', $iconOptions, \App\Facades\FormCopy::field('icon')->string(), ['class' => '', 'id' => 'icon']) !!}
</x-forms.field>
