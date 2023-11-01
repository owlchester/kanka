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
        {!! Form::select(
            $field['field'] . '_option',
            [
                '' => __('crud.filters.options.include'),
                'exclude' => __('crud.filters.options.exclude'),
                'none' => __('crud.filters.options.none'),
            ],
            $filterService->single($field['field'] . '_option'), [
                'class' => 'w-full entity-list-filter',
        ]) !!}
    </div>
</div>
