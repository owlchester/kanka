<x-forms.field
    field="name"
    :label="__('dashboard.widgets.fields.name')"
    tooltip
    :helper="isset($random) ?__('dashboard.widgets.random.helpers.name') : null">
    <input type="text" name="config[text]" value="{{ old('config[text]', $model->config['text'] ?? null) }}" maxlength="191" class="w-full" id="config[text]" placeholder="" />
</x-forms.field>
