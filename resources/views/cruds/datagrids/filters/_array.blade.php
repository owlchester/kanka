
@php
    $options = [
        '' => __('crud.filters.options.include'),
        'children' => __('crud.filters.options.children'),
        'exclude' => __('crud.filters.options.exclude'),
        'none' => __('crud.filters.options.none'),
    ];
    if (!isset($field['withChildren']) || $field['withChildren'] !== true) {
        unset($options['children']);
    }
    if ($field['type'] == 'selectMultiple' && isset($models)) {
        $selectedModels = $models;
        $ids = array_keys($selectedModels);
    } elseif (!empty($model) ) {
        $selectedModels = [$model->id => $model->name];
    } else {
        $selectedModels = [];
    }
@endphp
<div class="grid grid-cols-4 gap-2">
    <div class="col-span-3 text-left">
        <x-forms.select
            :name="($field['type'] == 'selectMultiple') ? $field['field'] . '[]' : $field['field']"
            :options="$selectedModels"
            :selected="$ids ?? null"
            class="select2 entity-list-filter"
            :multiple="$field['type'] == 'selectMultiple'"
            :extra="[
                'data-url' => $field['route'],
                'data-placeholder' => $field['placeholder'],
                'data-dropdown-parent' => '#datagrid-filters'
            ]" />
    </div>
    <div class="col-span-1 field">

        <x-forms.select
            :name="$field['field'] . '_option'"
            :options="$options"
            :selected="$filterService->single($field['field'] . '_option')"
            class="entity-list-option" />
    </div>
</div>
