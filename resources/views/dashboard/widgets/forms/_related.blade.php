
<div class="">
    <input type="hidden" name="config[attributes]" value="0" />
    <x-forms.field field="attributes" :label="__('dashboard.widgets.recent.show_attributes')">
        <x-checkbox :text="__('dashboard.widgets.recent.helpers.show_attributes')">
            <input type="checkbox" name="config[attributes]" value="1" @if (old('config[attributes]', isset($model) ? $model->conf('attributes') : false)) checked="checked" @endif id="config-attributes" @if (!$boosted) disabled="disabled" @endif />
        </x-checkbox>
    </x-forms.field>
</div>

<div class="">
    <input type="hidden" name="config[relations]" value="0" />
    <x-forms.field field="relations" :label="__('dashboard.widgets.recent.show_relations')">
        <x-checkbox :text="__('dashboard.widgets.recent.helpers.show_relations')">
            <input type="checkbox" name="config[relations]" value="1" @if (old('config[relations]', isset($model) ? $model->conf('relations') : false)) checked="checked" @endif id="config-relations" @if (!$boosted) disabled="disabled" @endif />
        </x-checkbox>
    </x-forms.field>
</div>

<div class="">
    <input type="hidden" name="config[members]" value="0" />
    <x-forms.field field="members" :label="__('dashboard.widgets.recent.show_members')">
        <x-checkbox :text="__('dashboard.widgets.recent.helpers.show_members')">
            <input type="checkbox" name="config[members]" value="1" @if (old('config[members]', isset($model) ? $model->conf('members') : false)) checked="checked" @endif id="config-members" @if (!$boosted) disabled="disabled" @endif />
        </x-checkbox>
    </x-forms.field>
</div>
