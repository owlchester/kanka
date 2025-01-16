<x-forms.field
    field="pronouns"
    :label="__('characters.fields.pronouns')">
    <input type="text" name="pronouns" value="{!! htmlspecialchars(old('pronouns', str_replace('&amp;', '&', FormCopy::field('pronouns')->child()->string() ?: $model->pronouns ?? ''))) !!}"
           placeholder="{{ __('characters.placeholders.pronouns') }}" maxlength="45" spellcheck="true" />
</x-forms.field>
