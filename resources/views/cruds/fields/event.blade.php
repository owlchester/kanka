@if ($campaign->enabled('events'))
    <?php
    $preset = null;
    if (isset($model) && $model->event) {
        $preset = $model->event;
    } else {
        $preset = FormCopy::field('event')->select();
    }?>
    <div class="form-group">
        {!! Form::foreignSelect(
            'event_id',
            [
                'preset' => $preset,
                'class' => App\Models\Event::class,
                'enableNew' => isset($enableNew) ? $enableNew : true,
                'labelKey' => isset($parent) ? 'events.fields.event' : null,
                'from' => isset($from) ? $from : null,
            ]
        ) !!}
    </div>
@endif
