<x-forms.field
    field="format"
    :label="__('calendars.fields.format')"
    :tooltip="true"
    :helper="__('calendars.helpers.format')"
    link="https://docs.kanka.io/en/latest/entities/calendars.html#date-format">
    {!! Form::text('format', isset($model) ? $model->format : null, ['class' => 'w-full']) !!}
</x-forms.field>
