@php $fieldname = $fieldname ?? 'font_colour'; @endphp
<x-forms.field field="font-colour" :label="__('maps/markers.fields.font_colour')">
    <span>
        <input type="text" name="{{ $fieldname }}" value="{{ old($fieldname, $source->$fieldname ?? $model->$fieldname ?? null) }}" class="spectrum" maxlength="7" data-append-to="{{ !isset($model) || empty($model) ? '#marker-modal' : $dropdownParent ?? null }}" />
    </span>
</x-forms.field>
