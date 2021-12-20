@if (!$campaign->enabled('journals'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->journal) {
    $preset = $model->journal;
} elseif (isset($isRandom) && $isRandom) {
    $preset = $random->generateForeign(\App\Models\Journal::class);
} elseif (isset($parent) && $parent) {
    $preset = FormCopy::field('journal')->select(true, \App\Models\Journal::class);
} else {
    $preset = FormCopy::field('journal')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Journal::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'journals.fields.journal';
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
        'journal_id',
        $data
    ) !!}
</div>
