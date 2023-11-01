<x-forms.field
    field="hidden"
    :label="__('tags.fields.is_hidden')">
    <select name="is_hidden">
        <option value=""></option>
        <option value="0">{{ __('general.no') }}</option>
        <option value="1">{{ __('general.yes') }}</option>
    </select>
</x-forms.field>
