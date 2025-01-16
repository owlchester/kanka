@if (!$campaign->enabled('abilities'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->ability) {
    $preset = $model->ability;
} elseif (isset($model) && $model->parent) {
    $preset = $model->parent;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\Ability::class);
}
@endphp

<x-forms.foreign
    :campaign="$campaign"
    name="ability_id"
    key="ability"
    entityType="abilities"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.ability')] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Ability::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.ability')">
</x-forms.foreign>

