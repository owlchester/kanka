<x-forms.field field="enabled" :label="__('attribute_templates.fields.is_enabled')">
    <select name="is_enabled" class="w-full">
        <option value=""></option>
        <option value="0">{{ __('general.no') }}</option>
        <option value="1">{{ __('general.yes') }}</option>
    </select>
</x-forms.field>
