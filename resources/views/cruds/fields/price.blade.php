<x-forms.field
    field="price"
    label="{{ __($trans . '.fields.price') }}">
    <input type="text" name="price" value="{!! old('price', $source->price ?? $model->price ) !!}" placeholder="{{ __($trans . '.placeholders.price') }}" maxlength="191" />
</x-forms.field>
