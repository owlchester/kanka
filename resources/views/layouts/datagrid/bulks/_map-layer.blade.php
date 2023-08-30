<?php
    $typeOptions = [
        '' => null,
        0 => __('maps/layers.types.standard'),
        1 => __('maps/layers.types.overlay'),
        2 => __('maps/layers.types.overlay_shown'),
    ];
?>
<x-grid type="1/1">
    <x-forms.field field="type" :label="__('maps/layers.fields.type')">
        {{ Form::select('type_id', $typeOptions, null, ['class' => '', 'id' => 'type_id']) }}
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['bulk' => true])
</x-grid>
