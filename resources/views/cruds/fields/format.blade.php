<x-forms.field
    field="format"
    :label="__('calendars.fields.format')"
    tooltip
    :helper="__('calendars.helpers.format')"
    link="https://docs.kanka.io/en/latest/entries/calendars.html#date-format">

    <input type="text" name="format" value="{{ old('format', $source->child->format ?? $source->format ?? $model->format ?? null) }}" maxlength="20" class="w-full"  />
</x-forms.field>
