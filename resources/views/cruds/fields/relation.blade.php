<x-forms.field
    field="relation"
    :required="!isset($bulk)"
    :label="__('entities/relations.fields.role')">
    <input type="text" name="relation" value="{!! htmlspecialchars(old('relation', $source->relation ?? $relation->relation ?? null)) !!}" maxlength="191" class="w-full"  placeholder="{{ __('entities/relations.placeholders.role') }}" />
</x-forms.field>
