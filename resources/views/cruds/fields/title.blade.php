@php
    $fieldID = uniqid('title_');
@endphp
<x-forms.field
    field="title"
    :label="__('characters.fields.title')"
    :id="$fieldID">

    <input id="{{ $fieldID }}" type="text" name="title"
           placeholder="{{ __('characters.placeholders.title') }}" maxlength="191" spellcheck="true"
           value="{!! htmlspecialchars(old('title', str_replace('&amp;', '&', FormCopy::field('title')->child()->string() ?: $model->title ?? ''))) !!}" />
</x-forms.field>
