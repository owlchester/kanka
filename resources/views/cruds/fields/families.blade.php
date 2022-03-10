@if (!$campaign->enabled('families'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->race) {
    $preset = $model->race;
} elseif (isset($isRandom) && $isRandom) {
    $preset = $random->generateForeign(\App\Models\Family::class);
} elseif (isset($parent) && $parent) {
    $preset = FormCopy::field('family')->select(true, \App\Models\Family::class);
} else {
    $preset = FormCopy::field('family')->select();
}
if (!isset($source)) {
    $source = null;
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Family::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'characters.fields.families';
}
if (isset($dropdownParent)) {
    $data['dropdownParent'] = $dropdownParent;
}
if (isset($from)) {
    $data['from'] = $from;
}
@endphp
<input type="hidden" name="save_families" value="1">
<div class="form-group">
    {!! Form::families(
        'id',
        [
            'model' => isset($model) ? $model : FormCopy::model(),
            'source' => $source
        ]
    ) !!}
</div>
