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
        {!! Form::foreignSelect(
            'family_id',
            [
                'preset' => $preset,
                'class' => App\Models\Family::class,
                'allowNew' => isset($enableNew) ? $enableNew : true,
                'labelKey' => isset($parent) && $parent ? 'families.fields.family' : null
            ]
        ) !!}
    </div>
@endif
