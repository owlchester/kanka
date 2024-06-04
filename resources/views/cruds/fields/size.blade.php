<x-forms.field
    field="size"
    label="{{ __($trans . '.fields.size') }}">
    <input type="text" name="size" value="{{ old('size', $source->size ?? $model->size ) }}" placeholder="{{ __($trans . '.placeholders.size') }}" maxlength="191" class="w-full" />
</x-forms.field>
