<x-forms.field
    field="title"
    :label="__('characters.fields.title')">
    {!! Form::text(
        'title',
        FormCopy::field('title')->string(),
        [
            'placeholder' => __('characters.placeholders.title'),
            'class' => 'w-full',
            'maxlength' => 191,
            'spellcheck' => 'true'
        ]
    ) !!}
</x-forms.field>
