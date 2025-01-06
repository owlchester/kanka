@if (!$campaign->enabled('families'))
    <?php return ?>
@endif

@php
    $preset = null;
    if (isset($model) && $model->parent) {
        $preset = $model->parent;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('parent')->select($isParent ?? false, \App\Models\Family::class);
    }
@endphp
<x-forms.foreign
    :campaign="$campaign"
    name="family_id"
    key="family"
    entityType="families"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.family')] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Family::class"
    :selected="$preset"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.family')">
</x-forms.foreign>
