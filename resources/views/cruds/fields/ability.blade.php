@if (!$campaignService->enabled('abilities'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->ability) {
    $preset = $model->ability;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('ability')->select($isParent ?? false, \App\Models\Ability::class);
}
@endphp

<x-forms.foreign
    name="ability_id"
    key="ability"
    entityType="abilities"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('abilities.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Ability::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null">
</x-forms.foreign>

