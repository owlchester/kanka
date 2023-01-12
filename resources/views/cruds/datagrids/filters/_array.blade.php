<div class="row">
    <div class="col-xs-8">
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
    <div class="col-xs-4">
        @php
            $options = [
                '' => __('crud.filters.options.include'),
                'exclude' => __('crud.filters.options.exclude'),
                'none' => __('crud.filters.options.none'),
            ];
            if (isset($field['withChildren']) && $field['withChildren'] === true ) {
                $options = array_slice($options, 0, 1, true) +
                array('children' => __('crud.filters.options.children')) +
                array_slice($options, 1, NULL, true);
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
