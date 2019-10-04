<div class="form-group required">
    <label>{{ trans($trans . '.fields.name') }}</label>
    {!! Form::text(
        'name',
        FormCopy::field('name')->string(),
        null,
        [
            'placeholder' => trans($trans . '.placeholders.name'),
            'class' => 'form-control',
            'maxlength' => 191
        ]
    ) !!}
</div>