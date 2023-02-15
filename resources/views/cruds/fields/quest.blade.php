@if (!$campaign->enabled('quests'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->quest) {
    $preset = $model->quest;
} elseif (isset($parent) && $parent) {
    $preset = FormCopy::field('quest')->select(true, \App\Models\Quest::class);
} else {
    $preset = FormCopy::field('quest')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Quest::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'quests.fields.quest';
}
if (isset($dropdownParent)) {
    $data['dropdownParent'] = $dropdownParent;
}
if (isset($from)) {
    $data['from'] = $from;
}
if (isset($quickCreator)) {
    $data['quickCreator'] = $quickCreator;
}
@endphp
<div class="form-group">
    {!! Form::foreignSelect(
        'quest_id',
        $data
    ) !!}
</div>
