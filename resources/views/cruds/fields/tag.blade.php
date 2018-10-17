@if ($campaign->enabled('tags'))
    <div class="form-group">
        {!! Form::select2(
            'tag_id',
            (isset($model) && $model->tag ? $model->tag : $formService->prefillSelect('tag', $source)),
            App\Models\Tag::class,
            true
        ) !!}
    </div>
@endif