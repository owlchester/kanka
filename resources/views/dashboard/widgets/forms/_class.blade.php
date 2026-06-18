<x-forms.field
    field="class"
    :label="__('dashboard.widgets.fields.class')"
    :helper="__('dashboard.widgets.helpers.class')"
    tooltip
>
    <input type="text" name="config[class]" value="{{ old('config[class]', $model->config['class'] ?? null) }}" maxlength="191" class="w-full" id="config[class]" placeholder="" />
</x-forms.field>
