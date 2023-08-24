@php
$fieldOptions = [
    'class' => 'form-control spectrum',
    'maxlength' => 7
];
if (isset($dropdownParent)) {
    $fieldOptions['data-append-to'] = $dropdownParent;
}

@endphp
<x-forms.field
    field="colour"
    :label="__('crud.fields.colour')">
    {!! Form::text('colour', null, $fieldOptions ) !!}
</x-forms.field>
