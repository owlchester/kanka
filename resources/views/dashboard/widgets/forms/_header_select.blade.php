<input type="hidden" name="config[entity-header]" value="0" />
<x-forms.field field="header" :label="__('dashboard.widgets.recent.entity-header')">
    <x-checkbox :text="__('dashboard.widgets.recent.helpers.entity-header')">
        <input type="checkbox" name="config[entity-header]" value="1" @if (old('config[entity-header]', isset($model) ? $model->conf('entity-header') : false)) checked="checked" @endif id="config-entity-header" @if (!$boosted) disabled="disabled" @endif />
    </x-checkbox>
</x-forms.field>
