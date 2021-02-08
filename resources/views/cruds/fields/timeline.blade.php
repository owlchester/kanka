@if ($campaign->enabled('timelines'))
    <?php
    $preset = null;
    if (isset($model) && $model->timeline) {
        $preset = $model->timeline;
    } else {
        $preset = FormCopy::field('timeline')->select();
    }?>
    <div class="form-group">
        {!! Form::foreignSelect(
            'timeline_id',
            [
                'preset' => $preset,
                'class' => App\Models\Timeline::class,
                'enableNew' => isset($enableNew) ? $enableNew : true,
                'labelKey' => isset($parent) ? 'timelines.fields.timeline' : null,
                'from' => isset($from) ? $from : null,
            ]
        ) !!}
    </div>
@endif
