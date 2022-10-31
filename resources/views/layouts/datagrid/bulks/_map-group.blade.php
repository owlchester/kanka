<?php
    $typeOptions = [
        '' => null,
        0 => __('general.no'),
        1 => __('general.yes'),
    ];
?>

<div class="form-group">
    <label>
        {{ __('maps/groups.fields.is_shown') }}
    </label>
    {{ Form::select('is_shown',  $typeOptions, null, ['class' => 'form-control', 'id' => 'type_id']) }}
</div>

<div class="form-group">
    @include('cruds.fields.visibility_id', ['bulk' => true])
</div>
