@if ($campaign->enabled('abilities'))
    <?php
    $preset = null;
    if (isset($model) && $model->ability) {
        $preset = $model->ability;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Ability::class);
    } else {
        $preset = FormCopy::field('ability')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'ability_id',
            $preset,
            App\Models\Ability::class,
            isset($enableNew) ? $enableNew : true,
            isset($parent) ? 'abilities.fields.ability' : null
        ) !!}
    </div>
@endif
