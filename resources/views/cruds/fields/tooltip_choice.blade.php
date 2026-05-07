<x-forms.field field="has-tooltip" :label="__('maps/markers.fields.has_tooltip')">
    <select name="is_popupless" class="w-full">
        <option value=""></option>
        <option value="0">{{ __('general.yes') }}</option>
        <option value="1">{{ __('general.no') }}</option>
    </select>
</x-forms.field>
