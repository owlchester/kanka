<x-forms.field
    field="age"
    :label="__($trans . '.fields.age')"
    :helper="isset($bulk) && $bulk ? __('crud.bulk.age.helper') : null">
    {!! Form::text(
        'age',
        FormCopy::field('name')->string(),
        [
            'placeholder' => __($trans . '.placeholders.age'),
            'class' => 'w-full',
            'maxlength' => 9
        ]
    ) !!}
</x-forms.field>
