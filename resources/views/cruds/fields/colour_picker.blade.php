@php
$fieldOptions = [
    'class' => 'spectrum',
    'maxlength' => 7
];
if (isset($dropdownParent)) {
    $fieldOptions['data-append-to'] = $dropdownParent;
}

@endphp
<x-forms.field
    field="colour"
    :label="__('crud.fields.colour')">
    <span>
    {!! Form::text('colour', $default ?? null, $fieldOptions ) !!}
    </span>
</x-forms.field>
