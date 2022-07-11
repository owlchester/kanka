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
        {!! Form::select(
            $field['field'] . '_option',
            [
                '' => __('crud.filters.options.include'),
                'exclude' => __('crud.filters.options.exclude'),
                'none' => __('crud.filters.options.none'),
            ],
            $filterService->single($field['field'] . '_option'), [
                'class' => 'form-control entity-list-filter',
        ]) !!}
    </div>
</div>
