@if (!$campaign->enabled('timelines'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->timeline) {
    $preset = $model->timeline;
} else {
    $preset = FormCopy::field('timeline')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Timeline::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'timelines.fields.timeline';
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
        'timeline_id',
        $data
    ) !!}
</div>
