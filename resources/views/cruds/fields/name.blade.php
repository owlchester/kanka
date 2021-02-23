<?php
$required = !isset($bulk);
$horizontalForm = isset($horizontalForm) ? $horizontalForm : false;
?>
<div class="form-group @if ($required) required @endif">
    <label @if($horizontalForm) class="control-label col-sm-3 col-lg-2" @endif>{{ __($trans . '.fields.name') }}</label>
    @if($horizontalForm) <div class="col-sm-9 col-lg-10"> @endif
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
    @if ($horizontalForm) </div> @endif

    <p class="text-yellow duplicate-entity-warning collapse out">
        {{ __('entities.creator.duplicate') }}<br /><span id="duplicate-entities"></span>
    </p>
</div>
