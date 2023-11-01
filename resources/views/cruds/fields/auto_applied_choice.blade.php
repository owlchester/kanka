<x-forms.field
    field="auto-apply"
    :label="__('tags.fields.is_auto_applied')">
    <select name="is_auto_applied">
        <option value=""></option>
        <option value="0">{{ __('general.no') }}</option>
        <option value="1">{{ __('general.yes') }}</option>
    </select>
</x-forms.field>
