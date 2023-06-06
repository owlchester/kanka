<div class="field-price">
    <label>{{ __($trans . '.fields.price') }}</label>
    {!! Form::text(
        'price',
        FormCopy::field('price')->string(),
        [
            'placeholder' => __($trans . '.placeholders.price'),
            'class' => 'form-control',
            'maxlength' => 191
        ]
    ) !!}
</div>
