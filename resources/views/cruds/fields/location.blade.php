@if (!$campaign->enabled('locations'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->location) {
    $preset = $model->location;
} elseif (isset($isRandom) && $isRandom) {
    $preset = $random->generateForeign(\App\Models\Location::class);
} else {
    $preset = FormCopy::field('location')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Location::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'locations.fields.location';
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
        'location_id',
        $data
    ) !!}
</div>
