<x-forms.field
    field="price"
    :label="__($trans . '.fields.price')">
    {!! Form::text(
        'price',
        FormCopy::field('price')->string(),
        [
            'placeholder' => __($trans . '.placeholders.price'),
            'maxlength' => 191
        ]
    ) !!}
</x-forms.field>
