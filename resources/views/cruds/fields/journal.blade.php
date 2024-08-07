@if (!$campaign->enabled('journals'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->parent) {
    $preset = $model->parent;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('parent')->select($isParent ?? false, \App\Models\Journal::class);
}
@endphp


<x-forms.foreign
    :campaign="$campaign"
    name="journal_id"
    key="journal"
    entityType="journals"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('journals.find', [$campaign] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Journal::class"
    :selected="$preset"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.journal')">
</x-forms.foreign>
