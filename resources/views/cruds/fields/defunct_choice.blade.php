<x-forms.field field="defunct" :label="__('organisations.fields.is_defunct')">
    <select name="is_defunct" class="w-full">
        <option value=""></option>
        <option value="0">{{ __('general.no') }}</option>
        <option value="1">{{ __('general.yes') }}</option>
    </select>
</x-forms.field>
