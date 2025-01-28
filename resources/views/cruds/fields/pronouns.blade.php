@php
    $fieldID = uniqid('pronouns_');
@endphp
<x-forms.field
    field="pronouns"
    :label="__('characters.fields.pronouns')"
    :id="$fieldID">
    <input id="{{ $fieldID }}" type="text" name="pronouns" value="{!! htmlspecialchars(old('pronouns', str_replace('&amp;', '&', FormCopy::field('pronouns')->child()->string() ?: $model->pronouns ?? ''))) !!}"
           placeholder="{{ __('characters.placeholders.pronouns') }}" maxlength="45" spellcheck="true" />
</x-forms.field>
