<x-forms.field
    field="charges"
    :label="__('abilities.fields.charges')">

    <input type="text" name="charges" value="{{ old('charges', $source->charges ?? $model->charges ?? null) }}" maxlength="120" class="w-full"  autocomplete="off" placeholder="{{ __('abilities.placeholders.charges') }}" />
</x-forms.field>
