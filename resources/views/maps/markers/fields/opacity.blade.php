<x-forms.field field="opacity" :label="__('maps/markers.fields.opacity')">
    <input type="number"
           name="{{ $fieldname ?? 'opacity' }}"
           value="{{ $source->opacity ?? old($fieldname ?? 'opacity', $model->opacity ?? (!isset($fieldname) ? 100 : null)) }}"
           class="w-full"
           maxlength="3"
           step="10"
           max="100"
           min="0"
           id="{{ $fieldname ?? 'opacity' }}" />
</x-forms.field>
