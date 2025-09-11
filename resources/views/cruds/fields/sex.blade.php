@php
$fieldID = uniqid('gender_');
@endphp
<x-forms.field
    field="sex"
    :label="__('characters.fields.sex')"
    :id="$fieldID">

    <input id="{{ $fieldID }}" type="text" name="sex" value="{!! htmlspecialchars(old('sex', str_replace('&amp;', '&', FormCopy::field('sex')->child()->string() ?: $model->sex ?? ''))) !!}" placeholder="{{ __('characters.placeholders.sex') }}" list="entity-gender-list" autocomplete="off" maxlength="45" spellcheck="true" />
    <datalist id="entity-gender-list">
        @foreach (\App\Facades\CharacterCache::campaign($campaign)->genderSuggestion() as $gender)
            <option value="{{ $gender }}">{!! $gender !!}</option>
        @endforeach
    </datalist>
</x-forms.field>
