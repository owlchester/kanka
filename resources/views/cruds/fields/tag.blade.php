@if (!$campaignService->enabled('tags'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->tag) {
    $preset = $model->tag;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('tag')->select($isParent ?? false, \App\Models\Tag::class);
}
@endphp

<x-forms.foreign
    name="tag_id"
    key="tag"
    entityType="tags"
    :label="$label ?? null"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('tags.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Tag::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.tag')">
</x-forms.foreign>
