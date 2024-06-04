<x-forms.field
    field="age"
    :label="__($trans . '.fields.age')"
    :helper="isset($bulk) && $bulk ? __('crud.bulk.age.helper') : null">

    <input type="text" name="age" value="{{ old('age', $source->age ?? $model->age ?? null) }}" maxlength="9" class="w-full"  autocomplete="off" placeholder="{{ __($trans . '.placeholders.age') }}" />
</x-forms.field>
