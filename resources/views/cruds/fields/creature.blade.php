@if (!$campaignService->enabled('creatures'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->creature) {
    $preset = $model->creature;
} elseif (isset($parent) && $parent) {
    $preset = FormCopy::field('creature')->select(true, \App\Models\Creature::class);
} else {
    $preset = FormCopy::field('creature')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Creature::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'creatures.fields.creature';
}
if (isset($dropdownParent)) {
    $data['dropdownParent'] = $dropdownParent;
} elseif (request()->ajax()) {
    $data['dropdownParent'] = '#entity-modal';
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
        'creature_id',
        $data
    ) !!}
</div>
