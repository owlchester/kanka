<?php
$required = !isset($bulk);
?>
<div class="field-name @if ($required) required @endif">
    <label>{{ __('crud.fields.name') }}</label>
    {!! Form::text(
        'name',
        null,
        [
            'placeholder' => __('crud.placeholders.name'),
            'class' => 'form-control',
            'maxlength' => 191,
            'data-live' => route('search.live', $campaign),
            'data-type' => \Illuminate\Support\Str::singular($trans),
            'data-id' => (isset($model) && !empty($model->id) && !empty($model->entity) ? $model->entity->id : null),
            'required' => $required ? 'required' : null
        ]
    ) !!}

    <p class="text-yellow duplicate-entity-warning collapse out !visible">
        {{ __('entities.creator.duplicate') }}<br /><span id="duplicate-entities"></span>
    </p>
</div>
