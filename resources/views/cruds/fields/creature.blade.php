@if (!$campaign->enabled('creatures'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->parent) {
    $preset = $model->parent;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\Creature::class);
}
@endphp

<x-forms.foreign
    :campaign="$campaign"
    name="creature_id"
    key="creature"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :dynamicNew="$dynamicNew ?? false"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.creature')] + (isset($entity) ? ['exclude' => $entity->id] : []))"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.creature')">
</x-forms.foreign>
