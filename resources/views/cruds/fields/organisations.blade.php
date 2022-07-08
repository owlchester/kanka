@if (!$campaignService->enabled('organisations'))
    <?php return ?>
@endif

<input type="hidden" name="save_organisations" value="1">
<div class="form-group">
    {!! Form::organisations(
        'id',
        [
            'model' => isset($model) ? $model : FormCopy::model(),
            'source' => isset($source) ? $source : null,
        ]
    ) !!}
</div>
