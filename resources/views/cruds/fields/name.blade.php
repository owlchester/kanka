<div class="form-group required">
    <label>{{ __($trans . '.fields.name') }}</label>
    {!! Form::text(
        'name',
        FormCopy::field('name')->string(),
        [
            'placeholder' => trans($trans . '.placeholders.name'),
            'class' => 'form-control',
            'maxlength' => 191,
            'data-live' => route('search.live'),
            'data-type' => \Illuminate\Support\Str::singular($trans),
            'data-id' => (isset($model) && !empty($model->id) ? $model->entity->id : null)
        ]
    ) !!}

    <p class="text-yellow duplicate-entity-warning collapse out">
        {{ __('entities.creator.duplicate') }}<br /><span id="duplicate-entities"></span>
    </p>
</div>
