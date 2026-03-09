<x-forms.field field="dead" :label="__('characters.fields.status')">
    <select name="status_id" class="w-full">
        <option value=""></option>
        <option value="0">{{ __('characters.status.alive') }}</option>
        <option value="1">{{ __('characters.status.dead') }}</option>
        <option value="2">{{ __('characters.status.missing') }}</option>
    </select>
</x-forms.field>
