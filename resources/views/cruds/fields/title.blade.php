<x-forms.field
    field="title"
    :label="__('characters.fields.title')">

    <input type="text" name="title" value="{!! htmlspecialchars(old('title', $source->title ?? $model->title ?? '')) !!}"
           placeholder="{{ __('characters.placeholders.title') }}" maxlength="191" spellcheck="true" />
</x-forms.field>
