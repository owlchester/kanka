<div class="grid grid-cols-4 gap-2">
    <div class="col-span-3">
        {!! Form::select($field['field'], (!empty($model) ? [$model->id => $model->name] : []),
            null,
            [
                'id' => $field['field'],
                'class' => 'form-control select2 entity-list-filter',
                'data-url' => $field['route'],
                'data-placeholder' => $field['placeholder'],
            ]
        ) !!}
    </div>
    <div class="col-span-1">
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
        {!! Form::select(
            $field['field'] . '_option',
            $options,
            $filterService->single($field['field'] . '_option'), [
                'class' => 'form-control entity-list-option',
        ]) !!}
    </div>
</div>
