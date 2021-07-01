@if ($campaign->enabled('quests'))
    <?php
    $preset = null;
    if (isset($model) && $model->ability) {
        $preset = $model->ability;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Quest::class);
    } else {
        $preset = FormCopy::field('quest')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'quest_id',
            $preset,
            App\Models\Quest::class,
            isset($enableNew) ? $enableNew : true,
            isset($parent) ? 'quests.fields.quest' : null
        ) !!}
    </div>
@endif
