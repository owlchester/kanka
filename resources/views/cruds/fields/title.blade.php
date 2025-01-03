<x-forms.field
    field="title"
    :label="__('characters.fields.title')">

    <input type="text" name="title"
           placeholder="{{ __('characters.placeholders.title') }}" maxlength="191" spellcheck="true"
           value="{!! htmlspecialchars(old('title', str_replace('&amp;', '&', $source->title ?? $model->title ?? ''))) !!}" />
</x-forms.field>
