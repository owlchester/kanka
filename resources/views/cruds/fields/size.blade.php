<div class="form-group">
    <label>{{ trans($trans . '.fields.size') }}</label>
    {!! Form::text(
        'size',
        FormCopy::field('size')->string(),
        [
            'placeholder' => trans($trans . '.placeholders.size'),
            'class' => 'form-control',
            'maxlength' => 191
        ]
    ) !!}
</div>
