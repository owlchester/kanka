{!! Form::hidden('config[entity-header]', 0) !!}
<x-forms.field field="header" :label="__('dashboard.widgets.recent.entity-header')">
    <x-checkbox :text="__('dashboard.widgets.recent.helpers.entity-header')">
        {!! Form::checkbox('config[entity-header]', 1, (!empty($model) ? $model->conf('entity-header') : null), ['id' => 'config-entity-header', 'disabled' => !$boosted ? 'disabled' : null]) !!}
    </x-checkbox>
</x-forms.field>
