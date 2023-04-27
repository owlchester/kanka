@if (!$campaignService->enabled('maps'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->map) {
    $preset = $model->map;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('map')->select($isParent ?? false, \App\Models\Map::class);
}
@endphp

<x-forms.foreign
    name="map"
    key="map"
    entityType="maps"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('maps.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Map::class"
    :selected="$preset"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.map')">
</x-forms.foreign>
