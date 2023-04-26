@if (!$campaignService->enabled('journals'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->journal) {
    $preset = $model->journal;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('journal')->select($isParent ?? false, \App\Models\Journal::class);
}
@endphp


<x-forms.foreign
    name="journal"
    key="journal"
    entityType="journals"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('journals.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Journal::class"
    :selected="$preset"
    :dropdownParent="$dropdownParent ?? null">
</x-forms.foreign>
