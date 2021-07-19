@if ($campaign->enabled('locations'))
    <?php
    $preset = null;
    if (isset($model) && $model->location) {
        $preset = $model->location;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Location::class);
    } else {
        $preset = FormCopy::field('location')->select();
    }
    ?>
    <div class="form-group">
        {!! Form::foreignSelect(
            'location_id',
            [
                'preset' => $preset,
                'class' => App\Models\Location::class,
                'enableNew' => isset($enableNew) ? $enableNew : true,
                'from' => isset($from) ? $from : null,
            ]
        ) !!}
    </div>
@endif
