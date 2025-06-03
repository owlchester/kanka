<x-forms.field
    field="class"
    :label="__('dashboard.widgets.fields.class')"
    :helper="__('dashboard.widgets.helpers.class')"
    tooltip
>
    <input type="text" name="config[class]" value="{{ old('config[class]', $model->config['class'] ?? null) }}" maxlength="191" class="w-full @if (!$boosted) bg-base-200 @endif" id="config[class]" @if (!$boosted) disabled="disabled" @endif placeholder="" />
</x-forms.field>
