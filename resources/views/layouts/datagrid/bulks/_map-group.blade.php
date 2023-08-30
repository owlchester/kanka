<?php
    $typeOptions = [
        '' => null,
        0 => __('general.no'),
        1 => __('general.yes'),
    ];
?>
<x-grid type="1/1">
    <x-forms.field field="group-shown" :label="__('maps/groups.fields.is_shown')">
        {{ Form::select('is_shown',  $typeOptions, null, ['class' => '', 'id' => 'type_id']) }}
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['bulk' => true])
</x-grid>
