<x-forms.field
    field="name"
    :label="__('dashboard.widgets.fields.name')"
    :tooltip="true"
    :helper="isset($random) ?__('dashboard.widgets.random.helpers.name') : null">
    {!! Form::text('config[text]', null, ['class' => '']) !!}
</x-forms.field>
