@if (!$campaign->enabled('notes'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->note) {
    $preset = $model->note;
} elseif (isset($isRandom) && $isRandom) {
    $preset = $random->generateForeign(\App\Models\Note::class);
} elseif (isset($parent) && $parent) {
    $preset = FormCopy::field('note')->select(true, \App\Models\Note::class);
} else {
    $preset = FormCopy::field('note')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Note::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'notes.fields.note';
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
        'note_id',
        $data
    ) !!}
</div>
