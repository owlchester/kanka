<x-forms.field field="pin-size" :label="__('maps/markers.fields.pin_size')">
    <input
        type="number"
        name="{{ $fieldname ?? 'pin_size' }}"
        value="{{ $source->pin_size ?? old($fieldname ?? 'pin_size', $model->pin_size ?? null) }}"
        class="w-full"
        maxlength="3"
        step="2"
        max="100"
        min="10"
        placeholder="40"
        id="{{ $fieldname ?? 'pin_size' }}" />
</x-forms.field>
