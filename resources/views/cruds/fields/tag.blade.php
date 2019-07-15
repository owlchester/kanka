@if ($campaign->enabled('tags'))
    <?php
    $preset = null;
    if (isset($model) && $model->tag) {
        $preset = $model->tag;
    } elseif (isset($parent) && $parent) {
        $preset = $formService->prefillSelect('tag', $source, true, \App\Models\Tag::class);
    } else {
        $preset = $formService->prefillSelect('tag', $source);
    }?>
    <div class="form-group">
        {!! Form::select2(
            'tag_id',
            $preset,
            App\Models\Tag::class,
            true
        ) !!}
    </div>
@endif