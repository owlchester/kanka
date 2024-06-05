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
        <x-forms.select name="type_id" :options="$typeOptions"  class="w-full" />
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['bulk' => true])
</x-grid>
