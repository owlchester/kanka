@if ($campaign->enabled('tags'))
    <div class="form-group">
        {!! Form::tags(
            'tag_id',
            [
                'model' => isset($model) ? $model : null
            ]
        ) !!}
    </div>
@endif