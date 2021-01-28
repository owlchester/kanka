@if ($campaign->enabled('journals'))
    <?php
    $preset = null;
    if (isset($model) && $model->journal) {
        $preset = $model->journal;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Journal::class);
    } elseif (isset($parent) && $parent) {
        $preset = FormCopy::field('journal')->select(true, \App\Models\Journal::class);
    } else {
        $preset = FormCopy::field('journal')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'journal_id',
            $preset,
            App\Models\Journal::class,
            isset($enableNew) ? $enableNew : true,
            isset($parent) ? 'journals.fields.journal' : null
        ) !!}
    </div>
@endif
