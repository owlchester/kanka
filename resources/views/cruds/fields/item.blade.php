@if (!$campaignService->enabled('items'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->item) {
    $preset = $model->item;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('item')->select($isParent ?? false, \App\Models\Item::class);
}
@endphp

<x-forms.foreign
    name="item_id"
    key="item"
    entityType="items"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('items.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Item::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null">
</x-forms.foreign>
