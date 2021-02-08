@if ($campaign->enabled('maps'))
    <?php
    $preset = null;
    if (isset($model) && $model->map) {
        $preset = $model->map;
    } else {
        $preset = FormCopy::field('map')->select();
    }?>
    <div class="form-group">
        {!! Form::foreignSelect(
            'map_id',
            [
                'preset' => $preset,
                'class' => App\Models\Map::class,
                'enableNew' => isset($enableNew) ? $enableNew : true,
                'labelKey' => isset($parent) ? 'maps.fields.map' : null,
                'from' => isset($from) ? $from : null,
            ]
        ) !!}
    </div>
@endif
