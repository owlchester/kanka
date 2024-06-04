<x-forms.field
    field="relation"
    :required="!isset($bulk)"
    :label="__('entities/relations.fields.relation')">
    <input type="text" name="relation" value="{{ old('relation', $source->relation ?? $model->relation ?? null) }}" maxlength="191" class="w-full"  placeholder="{{ __('entities/relations.placeholders.relation') }}" />
</x-forms.field>
