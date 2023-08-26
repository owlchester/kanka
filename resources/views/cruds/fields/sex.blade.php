<x-forms.field
    field="sex"
    :label="__('characters.fields.sex')">
    {!! Form::text(
        'sex',
        FormCopy::field('sex')->string(),
        [
            'placeholder' => __('characters.placeholders.sex'),
            'maxlength' => 45,
            'list' => 'entity-gender-list',
            'autocomplete' => 'off'
        ]
    ) !!}
    <datalist id="entity-gender-list">
        @foreach (\App\Facades\CharacterCache::genderSuggestion() as $gender)
            <option value="{{ $gender }}">{{ $gender }}</option>
        @endforeach
    </datalist>
</x-forms.field>
