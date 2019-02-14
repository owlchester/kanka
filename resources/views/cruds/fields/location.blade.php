@if ($campaign->enabled('locations'))
    <?php
    $preset = null;
    if (isset($model) && $model->location) {
        $preset = $model->location;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Location::class);
    } else {
        $preset = $formService->prefillSelect('location', $source);
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