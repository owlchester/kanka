@if (!$campaign->enabled('items'))
    <?php return ?>
@endif

@if (!isset($preset))
    @php
    $preset = null;
    if (isset($model) && $model->parent) {
        $preset = $model->parent;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\Item::class);
    }
    @endphp
@endif

<x-forms.foreign
    :campaign="$campaign"
    :name="isset($multiple) && $multiple ? 'item_id[]' : 'item_id'"
    :key="isset($multiple) && $multiple ? 'items' : 'item'"
    :required="$required ?? false"
    :allowNew="$allowNew ?? true"
    :dynamicNew="$dynamicNew ?? false"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :placeholder="isset($multiple) && $multiple ? __('crud.placeholders.multiple') : null"
    :route="route('search-list', [$campaign, config('entities.ids.item')] + (isset($entity) ? ['exclude' => $entity->id] : []))"
    :selected="$preset"
    :helper="$helper ?? null"
    :multiple="isset($multiple) ? $multiple : false"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.item')">
</x-forms.foreign>
