<x-forms.field
    field="weight"
    label="{{ __($trans . '.fields.weight') }}">
    <input type="text" name="weight" value="{{ old('weight', $source->weight ?? $model->weight ?? null) }}" placeholder="{{ __($trans . '.placeholders.weight') }}" maxlength="191" class="w-full" />
</x-forms.field>
