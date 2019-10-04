@if ($campaign->enabled('locations'))
    <?php
    $preset = null;
    if (isset($model) && $model->location) {
        $preset = $model->location;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Location::class);
    } else {
        $preset = FormCopy::field('location')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'location_id',
            $preset,
            App\Models\Location::class,
            isset($enableNew) ? $enableNew : true
        ) !!}
    </div>
@endif