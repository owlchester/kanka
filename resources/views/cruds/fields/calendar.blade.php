@if (!$campaign->enabled('calendars'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->calendar) {
    $preset = $model->calendar;
} elseif (isset($isRandom) && $isRandom) {
    $preset = $random->generateForeign(\App\Models\Calendar::class);
} else {
    $preset = FormCopy::field('calendar')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Calendar::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'calendars.fields.calendar';
}
if (isset($dropdownParent)) {
    $data['dropdownParent'] = $dropdownParent;
}
if (isset($from)) {
    $data['from'] = $from;
}
@endphp
<div class="form-group">
    {!! Form::foreignSelect(
        'calendar_id',
        $data
    ) !!}
</div>
