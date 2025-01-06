@if (!$campaign->enabled('notes'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->parent) {
    $preset = $model->parent;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('parent')->select($isParent ?? false, \App\Models\Note::class);
}
@endphp

<x-forms.foreign
    :campaign="$campaign"
    name="note_id"
    key="note"
    entityType="notes"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.note')] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Note::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.note')">
</x-forms.foreign>
