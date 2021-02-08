@if ($campaign->enabled('tags'))
    <?php
    $preset = null;
    if (isset($model) && $model->tag) {
        $preset = $model->tag;
    } elseif (isset($parent) && $parent) {
        $preset = FormCopy::field('tag')->select(true, \App\Models\Tag::class);
    } else {
        $preset = FormCopy::field('tag')->select();
    }?>
    <div class="form-group">
        {!! Form::foreignSelect(
            'tag_id',
            [
                'preset' => $preset,
                'class' => App\Models\Tag::class,
                'enableNew' => isset($enableNew) ? $enableNew : true,
                'labelKey' => isset($parent) ? 'tags.fields.tag' : null,
                'from' => isset($from) ? $from : null,
            ]
        ) !!}
    </div>
@endif
