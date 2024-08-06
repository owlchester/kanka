<x-forms.field
    field="format"
    :label="__('calendars.fields.format')"
    tooltip
    :helper="__('calendars.helpers.format')"
    link="https://docs.kanka.io/en/latest/entities/calendars.html#date-format">

    <input type="text" name="format" value="{{ old('format', $source->format ?? $model->format ?? null) }}" maxlength="191" class="w-full"  />
</x-forms.field>
