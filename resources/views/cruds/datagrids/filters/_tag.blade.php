<div class="row">
    <div class="col-xs-8">
        <x-forms.tags
            label=""
            allowClear="true"
            :options="$value"
            dropdownParent="#datagrid-filters">
        </x-forms.tags>
    </div>
    <div class="col-xs-4">
        {!! Form::select(
            $field['field'] . '_option',
            [
                '' => __('crud.filters.options.include'),
                'exclude' => __('crud.filters.options.exclude'),
                'none' => __('crud.filters.options.none'),
            ],
            $filterService->single($field['field'] . '_option'), [
                'class' => 'form-control  entity-list-filter',
        ]) !!}
    </div>
</div>
