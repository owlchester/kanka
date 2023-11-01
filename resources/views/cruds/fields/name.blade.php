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
            'data-duplicate' => '.duplicate-warning',
            'data-id' => (isset($model) && !empty($model->id) && !empty($model->entity) ? $model->entity->id : null),
            'required' => $required ? 'required' : null
        ]
    ) !!}

    <div class="text-warning-content duplicate-warning flex flex-col gap-1" style="display: none">
        <span>{{ __('entities.creator.duplicate') }}</span>
        <div class="duplicates flex flex-wrap gap-2 items-center"></div>
    </div>
</x-forms.field>
