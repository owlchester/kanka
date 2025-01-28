<x-forms.field field="opacity" :label="__('maps/markers.fields.opacity')">
    <input type="number"
           name="{{ $fieldname ?? 'opacity' }}"
           value="{{ $source->opacity ?? old($fieldname ?? 'opacity', $model->opacity ?? (!isset($fieldname) ? 100 : null)) }}"
           class="w-full"
           maxlength="3"
           step="1"
           max="100"
           min="0"
           placeholder="1% - 100%"
           id="{{ $fieldname ?? 'opacity' }}" />
</x-forms.field>
