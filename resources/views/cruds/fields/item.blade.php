@if (
    (isset($campaign) && $campaign instanceof \App\Models\Campaign && !$campaign->enabled('items')) ||
    (isset($campaignService) && !$campaignService->enabled('items')))
    <?php return ?>
@endif

@if (!isset($preset))
    @php
    $preset = null;
    if (isset($model) && $model->item) {
        $preset = $model->item;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('item')->select($isParent ?? false, \App\Models\Item::class);
    }
    @endphp
@endif

<x-forms.foreign
    name="item_id"
    key="item"
    entityType="items"
    :required="$required ?? false"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('items.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Item::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.item')">
</x-forms.foreign>
