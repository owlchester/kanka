@if (!$campaign->enabled('events'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->event) {
    $preset = $model->event;
} else {
    $preset = FormCopy::field('event')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Event::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'events.fields.event';
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
        'event_id',
        $data
    ) !!}
</div>
