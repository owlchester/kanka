<x-forms.field field="is-draggable" :label="__('maps/markers.fields.is_draggable')">
    <select name="is_draggable" class="w-full">
        <option value=""></option>
        <option value="0">{{ __('general.no') }}</option>
        <option value="1">{{ __('general.yes') }}</option>
    </select>
</x-forms.field>
