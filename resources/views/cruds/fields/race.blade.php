@if (!$campaign->enabled('races'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->parent) {
    $preset = $model->parent;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\Race::class);
}
@endphp

<x-forms.foreign
    :campaign="$campaign"
    name="race_id"
    key="race"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :dynamicNew="$dynamicNew ?? false"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.race')] + (isset($entity) ? ['exclude' => $entity->id] : []))"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.race')">
</x-forms.foreign>

