{!! Form::hidden('config[entity-header]', 0) !!}
<x-forms.field field="header" :label="__('dashboard.widgets.recent.entity-header')">
    <label class="text-neutral-content cursor-pointer flex gap-2 items-start">
        {!! Form::checkbox('config[entity-header]', 1, (!empty($model) ? $model->conf('entity-header') : null), ['id' => 'config-entity-header', 'disabled' => !$boosted ? 'disabled' : null]) !!}
        {{ __('dashboard.widgets.recent.helpers.entity-header') }}
    </label>
</x-forms.field>
