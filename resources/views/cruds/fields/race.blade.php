@if ($campaign->enabled('races'))
    <?php
    $preset = null;
    if (isset($model) && $model->race) {
        $preset = $model->race;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Race::class);
    } elseif (isset($parent) && $parent) {
        $preset = FormCopy::field('race')->select(true, \App\Models\Race::class);
    } else {
        $preset = FormCopy::field('race')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'race_id',
            $preset,
            App\Models\Race::class,
            isset($enableNew) ? $enableNew : true,
            isset($parent) ? 'races.fields.race' : null
        ) !!}
    </div>
@endif
