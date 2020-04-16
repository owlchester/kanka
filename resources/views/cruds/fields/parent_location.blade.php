@if ($campaign->enabled('locations'))
    <?php
    $preset = null;
    if (isset($model) && $model->parentLocation) {
        $preset = $model->parentLocation;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Location::class);
    } else {
        $preset = FormCopy::field('parentLocation')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'parent_location_id',
            $preset,
            App\Models\Location::class,
            isset($enableNew) ? $enableNew : true,
            'crud.fields.location',
            'locations.find',
            'locations.placeholders.location'
        ) !!}
    </div>
@endif
