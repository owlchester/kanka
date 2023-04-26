@if (!$campaignService->enabled('creatures'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->creature) {
    $preset = $model->creature;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('creature')->select($isParent ?? false, \App\Models\Creature::class);
}
@endphp

<x-forms.foreign
    name="creature_id"
    key="creature"
    entityType="creatures"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('creatures.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Creature::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null">
</x-forms.foreign>
