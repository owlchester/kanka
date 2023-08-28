<x-forms.field
    field="pronouns"
    :label="__('characters.fields.pronouns')">
    {!! Form::text(
        'pronouns',
        null,
        [
            'placeholder' => __('characters.placeholders.pronouns'),
            'maxlength' => 45,
        ]
    ) !!}
</x-forms.field>
