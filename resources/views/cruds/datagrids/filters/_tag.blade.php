<div class="grid gap-2 md:gap-4 grid-cols-4">
    @php($selectedOption = $filterService->single($field['field'] . '_option'))
    @if (in_array($selectedOption, ['include', 'all'], true))
        @php($selectedOption = '')
    @endif
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
            :options="['any' => __('crud.filters.options.include_any'),
                '' => __('crud.filters.options.include_all'),
                'exclude' => __('crud.filters.options.exclude_any'),
                'exclude_all' => __('crud.filters.options.exclude_all'),
                'none' => __('crud.filters.options.none'),
                'not_empty' => __('crud.filters.options.not_empty'),]"
            :selected="$selectedOption"
            class="select2 entity-list-filter" />
    </div>
</div>
