@if ($campaign->enabled('families'))
    <?php
    $preset = null;
    if (isset($model) && $model->family) {
        $preset = $model->family;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Family::class);
    } else {
        $preset = FormCopy::field('family')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'family_id',
            $preset,
            App\Models\Family::class,
            isset($enableNew) ? $enableNew : true,
            isset($parent) ? 'families.fields.family' : null
        ) !!}
    </div>
@endif
