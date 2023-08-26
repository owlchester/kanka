<x-forms.field
    field="charges"
    :label="__('abilities.fields.charges')">
    {!! Form::text(
        'charges',
        FormCopy::field('charges')->string(),
        [
            'placeholder' => trans('abilities.placeholders.charges'),
            'maxlength' => 120,
            'autocomplete' => 'off'
        ]
    ) !!}
</x-forms.field>
