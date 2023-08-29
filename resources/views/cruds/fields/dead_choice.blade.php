<x-forms.field field="dead" :label="__('characters.fields.is_dead')">
    <select name="is_dead" class="w-full">
        <option value=""></option>
        <option value="0">{{ __('general.no') }}</option>
        <option value="1">{{ __('general.yes') }}</option>
    </select>
</x-forms.field>
