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
        {!! Form::select2(
            'tag_id',
            $preset,
            App\Models\Tag::class,
            isset($enableNew) ? $enableNew : true,
            isset($parent) ? 'tags.fields.tag' : null
        ) !!}
    </div>
@endif
