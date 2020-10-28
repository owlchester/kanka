<?php $required = !isset($bulk); ?>
<div class="form-group @if ($required) required @endif">
    <label>{{ __($trans . '.fields.name') }}</label>
    {!! Form::text(
        'name',
        null,
        [
            'placeholder' => trans($trans . '.placeholders.name'),
            'class' => 'form-control',
            'maxlength' => 191,
            'data-live' => route('search.live'),
            'data-type' => \Illuminate\Support\Str::singular($trans),
            'data-id' => (isset($model) && !empty($model->id) && !empty($model->entity) ? $model->entity->id : null),
            'required' => $required ? 'required' : null
        ]
    ) !!}

    <p class="text-yellow duplicate-entity-warning collapse out">
        {{ __('entities.creator.duplicate') }}<br /><span id="duplicate-entities"></span>
    </p>
</div>
