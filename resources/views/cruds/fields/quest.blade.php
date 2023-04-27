@if (!$campaignService->enabled('quests'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->quest) {
    $preset = $model->quest;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('quest')->select($isParent ?? false, \App\Models\Quest::class);
}
@endphp

<x-forms.foreign
    name="quest_id"
    key="quest"
    entityType="quests"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('quests.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Quest::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.quest')">
</x-forms.foreign>
