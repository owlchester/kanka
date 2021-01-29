@if ($campaign->enabled('events'))
    <?php
    $preset = null;
    if (isset($model) && $model->event) {
        $preset = $model->event;
    } else {
        $preset = FormCopy::field('event')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'event_id',
            $preset,
            App\Models\Event::class,
            isset($enableNew) ? $enableNew : true,
            isset($parent) ? 'events.fields.event' : null
        ) !!}
    </div>
@endif
