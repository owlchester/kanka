@if ($campaign->enabled('notes'))
    <?php
    $preset = null;
    if (isset($model) && $model->note) {
        $preset = $model->note;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Note::class);
    } elseif (isset($parent) && $parent) {
        $preset = FormCopy::field('note')->select(true, \App\Models\Note::class);
    } else {
        $preset = FormCopy::field('note')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'note_id',
            $preset,
            App\Models\Note::class,
            isset($enableNew) ? $enableNew : true,
            isset($parent) ? 'notes.fields.note' : null
        ) !!}
    </div>
@endif
