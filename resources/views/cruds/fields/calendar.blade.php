@if ($campaign->enabled('calendars'))
    <?php
    $preset = null;
    if (isset($model) && $model->calendar) {
        $preset = $model->calendar;
    } elseif (isset($isRandom) && $isRandom) {
        $preset = $random->generateForeign(\App\Models\Calendar::class);
    } else {
        $preset = FormCopy::field('calendar')->select();
    }?>
    <div class="form-group">
        {!! Form::select2(
            'calendar_id',
            $preset,
            App\Models\Calendar::class,
            isset($enableNew) ? $enableNew : true
        ) !!}
    </div>
@endif
