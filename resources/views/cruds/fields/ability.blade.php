@if (!$campaign->enabled('abilities'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->ability) {
    $preset = $model->ability;
} elseif (isset($isRandom) && $isRandom) {
    $preset = $random->generateForeign(\App\Models\Ability::class);
} else {
    $preset = FormCopy::field('ability')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Ability::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'abilities.fields.ability';
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
        'ability_id',
        $data
    ) !!}
</div>

