<x-forms.field
    field="class"
    :label="__('dashboard.widgets.fields.class')"
    :helper="__('dashboard.widgets.helpers.class')"
    :tooltip="true"
>
    {!! Form::text('config[class]', null, ['class' => 'form-control', 'id' => 'config[class]', 'disabled' => !$boosted ? 'disabled' : null]) !!}
</x-forms.field>
