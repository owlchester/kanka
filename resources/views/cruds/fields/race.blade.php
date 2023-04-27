@if (!$campaignService->enabled('races'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->race) {
    $preset = $model->race;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('race')->select($isParent ?? false, \App\Models\Race::class);
}
@endphp

<x-forms.foreign
    name="race_id"
    key="race"
    entityType="races"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('races.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Race::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.race')">
</x-forms.foreign>

