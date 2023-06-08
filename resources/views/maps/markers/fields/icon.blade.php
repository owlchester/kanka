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
<div class="field-icon">
    <label for="icon">{{ __('maps/markers.fields.icon') }}</label>
    {!! Form::select($fieldname ?? 'icon', $iconOptions, \App\Facades\FormCopy::field('icon')->string(), ['class' => 'form-control', 'id' => 'icon']) !!}
</div>
