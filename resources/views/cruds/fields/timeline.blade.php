@if ($campaign->enabled('timelines'))
    <?php
    $preset = null;
    if (isset($model) && $model->timeline) {
        $preset = $model->timeline;
    } else {
        $preset = FormCopy::field('timeline')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'timeline_id',
            $preset,
            App\Models\Timeline::class,
            isset($enableNew) ? $enableNew : true,
            isset($parent) ? 'timelines.fields.timeline' : null
        ) !!}
    </div>
@endif
