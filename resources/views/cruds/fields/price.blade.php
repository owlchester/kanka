<div class="form-group">
    <label>{{ trans($trans . '.fields.price') }}</label>
    {!! Form::text(
        'price',
        FormCopy::field('price')->string(),
        [
            'placeholder' => trans($trans . '.placeholders.price'),
            'class' => 'form-control',
            'maxlength' => 191
        ]
    ) !!}
</div>