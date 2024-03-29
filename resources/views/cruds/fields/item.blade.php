@if (isset($campaign) && $campaign instanceof \App\Models\Campaign && !$campaign->enabled('items'))
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
    :campaign="$campaign"
    name="item_id"
    key="item"
    entityType="items"
    :required="$required ?? false"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('items.find', [$campaign] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Item::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.item')">
</x-forms.foreign>
