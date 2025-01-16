@if (!$campaign->enabled('locations'))
    <?php return ?>
@endif

@php
    $preset = null;
    if (isset($model) && $model->location) {
        $preset = $model->location;
    } elseif (isset($model) && ($isParent ?? false) && $model->parent) {
        $preset = $model->parent;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field(isset($isParent) && $isParent ? 'parent' : 'location')->child()->select($isParent ?? false, \App\Models\Location::class);
    }
@endphp
<x-forms.foreign
    :campaign="$campaign"
    name="location_id"
    key="location"
    entityType="locations"
    :allowNew="$allowNew ?? true"
    :dynamicNew="$dynamicNew ?? false"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.location')] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Location::class"
    :selected="$preset"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.location')">
</x-forms.foreign>
