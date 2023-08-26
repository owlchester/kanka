<x-forms.field
    field="size"
    :label="__($trans . '.fields.size')">
    {!! Form::text(
        'size',
        FormCopy::field('size')->string(),
        [
            'placeholder' => __($trans . '.placeholders.size'),
            'class' => 'form-control',
            'maxlength' => 191
        ]
    ) !!}
</x-forms.field>
