@php
$fieldOptions = [
    'class' => 'form-control spectrum',
    'maxlength' => 7
];
if (isset($dropdownParent)) {
    $fieldOptions['data-append-to'] = $dropdownParent;
}

@endphp

<div class="form-group">
    <label>{{ __('crud.fields.colour') }}</label>
    {!! Form::text('colour', null, $fieldOptions ) !!}
</div>
