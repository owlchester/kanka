@if (!$campaignService->enabled('notes'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->note) {
    $preset = $model->note;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('note')->select($isParent ?? false, \App\Models\Note::class);
}
@endphp

<x-forms.foreign
    name="note_id"
    key="note"
    entityType="notes"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('notes.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Note::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null">
</x-forms.foreign>
