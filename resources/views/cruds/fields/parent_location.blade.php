@if (!$campaign->enabled('locations'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->parentLocation) {
    $preset = $model->parentLocation;
} elseif (isset($isRandom) && $isRandom) {
    $preset = $random->generateForeign(\App\Models\Location::class);
} else {
    $preset = FormCopy::field('parentLocation')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Location::class,
    'labelKey' => 'locations.fields.location',
    'placeholderKey' => 'locations.placeholders.location',
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
        'parent_location_id',
        $data
        /*$preset,
        App\Models\Location::class,
        isset($enableNew) ? $enableNew : true,
        'locations.fields.location',
        'locations.find',
        'locations.placeholders.location'*/
    ) !!}
</div>
