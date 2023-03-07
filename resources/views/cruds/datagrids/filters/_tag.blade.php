<div class="row">
    <div class="col-xs-8">
        {!! Form::tags(
            $field['field'],
            [
                'id' => $field['field'] . '_' . uniqid(),
                'model' => null,
                'enableNew' => false,
                'allowClear' => 'false',
                'label' => false,
                'filterOptions' => $value,
                'class' => 'entity-list-filter',
                'campaign' => $campaign,
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
                'class' => 'form-control  entity-list-filter',
        ]) !!}
    </div>
</div>
