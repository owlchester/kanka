@if ($campaign->enabled('tags'))
    <div class="form-group">
        {!! Form::tags(
            'tag_id',
            [
                'model' => isset($model) ? $model : FormCopy::model()
            ]
        ) !!}
    </div>
@endif