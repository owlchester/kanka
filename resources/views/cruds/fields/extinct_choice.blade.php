<x-forms.field field="extinct" :label="__('creatures.fields.is_extinct')">
    <select name="is_extinct" class="w-full">
        <option value=""></option>
        <option value="0">{{ __('general.no') }}</option>
        <option value="1">{{ __('general.yes') }}</option>
    </select>
</x-forms.field>
