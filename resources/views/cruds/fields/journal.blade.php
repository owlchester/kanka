@if (!$campaign->enabled('journals'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->parent) {
    $preset = $model->parent;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\Journal::class);
}
@endphp


<x-forms.foreign
    :campaign="$campaign"
    name="journal_id"
    key="journal"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :dynamicNew="$dynamicNew ?? false"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.journal')] + (isset($model) ? ['exclude' => $model->id] : []))"
    :selected="$preset"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.journal')">
</x-forms.foreign>
