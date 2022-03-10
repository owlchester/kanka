@if (!$campaign->enabled('families'))
    <?php return ?>
@endif

<input type="hidden" name="save_families" value="1">
<div class="form-group">
    {!! Form::families(
        'id',
        [
            'model' => isset($model) ? $model : FormCopy::model(),
            'source' => $source
        ]
    ) !!}
</div>
