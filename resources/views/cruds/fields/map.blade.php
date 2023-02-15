@if (!$campaign->enabled('maps'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->map) {
    $preset = $model->map;
} elseif (isset($parent) && $parent) {
    $preset = FormCopy::field('map')->select(true, \App\Models\Map::class);
} else {
    $preset = FormCopy::field('map')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Map::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'maps.fields.map';
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
        'map_id',
        $data
    ) !!}
</div>
