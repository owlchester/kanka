@if ($campaign->enabled('maps'))
    <?php
    $preset = null;
    if (isset($model) && $model->map) {
        $preset = $model->map;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Map::class);
    } else {
        $preset = FormCopy::field('map')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'map_id',
            $preset,
            App\Models\Map::class,
            isset($enableNew) ? $enableNew : true,
            isset($parent) ? 'maps.fields.map' : null
        ) !!}
    </div>
@endif
