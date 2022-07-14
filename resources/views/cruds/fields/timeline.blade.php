@if (!$campaignService->enabled('timelines'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->timeline) {
    $preset = $model->timeline;
} elseif (isset($parent) && $parent) {
    $preset = FormCopy::field('timeline')->select(true, \App\Models\Timeline::class);
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
if (isset($quickCreator)) {
    $data['quickCreator'] = true;
}
@endphp
<div class="form-group">
    {!! Form::foreignSelect(
        'timeline_id',
        $data
    ) !!}
</div>
