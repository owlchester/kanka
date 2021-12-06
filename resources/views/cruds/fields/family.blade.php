@if (!$campaign->enabled('families'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->family) {
    $preset = $model->family;
} elseif (isset($isRandom) && $isRandom) {
    $preset = $random->generateForeign(\App\Models\Family::class);
} else {
    $preset = FormCopy::field('family')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Family::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'families.fields.family';
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
        'family_id',
        $data
    ) !!}
</div>
