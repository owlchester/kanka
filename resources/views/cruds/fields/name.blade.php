<?php
$required = !isset($bulk);
?>

<x-forms.field
    field="name"
    :label="__('crud.fields.name')"
    :required="$required">
    {!! Form::text(
        'name',
        null,
        [
            'placeholder' => __('crud.placeholders.name'),
            'maxlength' => 191,
            'data-live' => route('search.live', $campaign),
            'data-type' => \Illuminate\Support\Str::singular($trans),
            'data-id' => (isset($model) && !empty($model->id) && !empty($model->entity) ? $model->entity->id : null),
            'required' => $required ? 'required' : null
        ]
    ) !!}

    <p class="text-warning-content duplicate-entity-warning collapse out !visible">
        {{ __('entities.creator.duplicate') }}<br /><span id="duplicate-entities"></span>
    </p>
</x-forms.field>
