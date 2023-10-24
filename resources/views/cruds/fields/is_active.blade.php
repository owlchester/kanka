<x-forms.field
    field="active"
    :label="__('bookmarks.fields.active')">
    <select name="is_active" id="is_active">
        <option value=""></option>
        <option value="1">{{ __('general.yes') }}</option>
        <option value="0">{{ __('general.no') }}</option>
    </select>
</x-forms.field>
