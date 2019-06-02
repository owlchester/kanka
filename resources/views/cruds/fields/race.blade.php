@if ($campaign->enabled('races'))
    <?php
    $preset = null;
    if (isset($model) && $model->race) {
        $preset = $model->race;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Race::class);
    } elseif (isset($parent) && $parent) {
        $preset = $formService->prefillSelect('race', $source, true, \App\Models\Race::class);
    } else {
        $preset = $formService->prefillSelect('race', $source);
    }?>
    <div class="form-group">
        {!! Form::select2(
            'race_id',
            $preset,
            App\Models\Race::class,
            isset($enableNew) ? $enableNew : true
        ) !!}
    </div>
@endif