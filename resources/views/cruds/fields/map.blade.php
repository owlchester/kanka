@if (!$campaign->enabled('maps'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->parent) {
    $preset = $model->parent;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\Map::class);
}
@endphp

<x-forms.foreign
    :campaign="$campaign"
    name="map_id"
    key="map"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.map')] + (isset($model) ? ['exclude' => $model->id] : []))"
    :selected="$preset"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.map')">
</x-forms.foreign>
