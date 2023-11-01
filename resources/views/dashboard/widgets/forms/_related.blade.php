
<div class="">
    {!! Form::hidden('config[attributes]', 0) !!}
    <x-forms.field field="attributes" :label="__('dashboard.widgets.recent.show_attributes')">
        <x-checkbox :text="__('dashboard.widgets.recent.helpers.show_attributes')">
            {!! Form::checkbox('config[attributes]', 1, (!empty($model) ? $model->conf('attributes') : null), ['id' => 'config-attributes', 'disabled' => !$boosted ? 'disabled' : null]) !!}
        </x-checkbox>
    </x-forms.field>
</div>

<div class="">
    {!! Form::hidden('config[relations]', 0) !!}
    <x-forms.field field="relations" :label="__('dashboard.widgets.recent.show_relations')">
        <x-checkbox :text="__('dashboard.widgets.recent.helpers.show_relations')">
            {!! Form::checkbox('config[relations]', 1, (!empty($model) ? $model->conf('relations') : null), ['id' => 'config-relations', 'disabled' => !$boosted ? 'disabled' : null]) !!}
        </x-checkbox>
    </x-forms.field>
</div>

<div class="">
    {!! Form::hidden('config[members]', 0) !!}
    <x-forms.field field="members" :label="__('dashboard.widgets.recent.show_members')">
        <x-checkbox :text="__('dashboard.widgets.recent.helpers.show_members')">
            {!! Form::checkbox('config[members]', 1, (!empty($model) ? $model->conf('members') : null), ['id' => 'config-members', 'disabled' => !$boosted ? 'disabled' : null]) !!}
        </x-checkbox>
    </x-forms.field>
</div>
