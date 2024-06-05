<div class="grid grid-cols-4 gap-2">
    <div class="col-span-3 text-left">
        <x-forms.select
            :name="$field['field']"
            :options="!empty($model) ? [$model->id => $model->name] : []"
            :id="$field['field']"
            class="select2 entity-list-filter"
            :extra="[
                'data-url' => $field['route'],
                'data-placeholder' => $field['placeholder'],
                'data-dropdown-parent' => '#datagrid-filters'
            ]" />
    </div>
    <div class="col-span-1 field">
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
        @endphp
        <x-forms.select
            :name="$field['field'] . '_option'"
            :options="$options"
            :selected="$filterService->single($field['field'] . '_option')"
            class="entity-list-option" />
    </div>
</div>
