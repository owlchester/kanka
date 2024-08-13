<x-forms.field field="destroyed" :label="__('locations.fields.is_destroyed')">
    <select name="is_destroyed" class="w-full">
        <option value=""></option>
        <option value="0">{{ __('general.no') }}</option>
        <option value="1">{{ __('general.yes') }}</option>
    </select>
</x-forms.field>
