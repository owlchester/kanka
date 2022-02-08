@if (!$campaign->enabled('characters'))
    @php return @endphp
@endif

@php
$preset = null;
if (isset($model) && $model->character) {
    $preset = $model->character;
} elseif (isset($isRandom) && $isRandom) {
    $preset = $random->generateForeign(\App\Models\Character::class);
} else {
    $preset = FormCopy::field('character')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Character::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'characters.fields.character';
}
if (isset($labelKey)) {
    $data['labelKey'] = __($labelKey);
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
        'character_id',
        $data
    ) !!}
</div>
