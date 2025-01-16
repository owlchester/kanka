@if (!$campaign->enabled('tags'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->parent) {
    $preset = $model->parent;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\Tag::class);
}
@endphp

<x-forms.foreign
    :campaign="$campaign"
    name="tag_id"
    key="tag"
    entityType="tags"
    :label="$label ?? null"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.tag')] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Tag::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.tag')">
</x-forms.foreign>
