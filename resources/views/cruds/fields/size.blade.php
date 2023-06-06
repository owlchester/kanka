<div class="field-size">
    <label>{{ __($trans . '.fields.size') }}</label>
    {!! Form::text(
        'size',
        FormCopy::field('size')->string(),
        [
            'placeholder' => __($trans . '.placeholders.size'),
            'class' => 'form-control',
            'maxlength' => 191
        ]
    ) !!}
</div>
