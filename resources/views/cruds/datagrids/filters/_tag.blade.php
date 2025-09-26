<div class="grid gap-2 md:gap-4 grid-cols-4">
    <div class="col-span-3">
        <x-forms.tags
            :campaign="$campaign"
            label=""
            allowClear="true"
            :options="$value"
            dropdownParent="#datagrid-filters">
        </x-forms.tags>
    </div>
    <div class="">
        <x-forms.select
            :name="$field['field'] . '_option'"
            :options="['' => __('crud.filters.options.include'),
                'exclude' => __('crud.filters.options.exclude'),
                'any' => __('crud.filters.options.any'),
                'none' => __('crud.filters.options.none'),]"
            :selected="$filterService->single($field['field'] . '_option')"
            class="select2 entity-list-filter" />
    </div>
</div>
