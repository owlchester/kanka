<?php
    $typeOptions = [
        '' => null,
        0 => __('general.no'),
        1 => __('general.yes'),
    ];
?>

<x-forms.field field="group-shown" :label="__('maps/groups.fields.is_shown')">
    {{ Form::select('is_shown',  $typeOptions, null, ['class' => 'form-control', 'id' => 'type_id']) }}
</x-forms.field>

@include('cruds.fields.visibility_id', ['bulk' => true])
