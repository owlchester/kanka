<?php
    $typeOptions = [
        '' => null,
        0 => __('maps/layers.types.standard'),
        1 => __('maps/layers.types.overlay'),
        2 => __('maps/layers.types.overlay_shown'),
    ];
?>

<div class="field-type">
    <label>{{ __('maps/layers.fields.type') }}</label>
    {{ Form::select('type_id', $typeOptions, null, ['class' => 'form-control', 'id' => 'type_id']) }}
</div>

@include('cruds.fields.visibility_id', ['bulk' => true])
