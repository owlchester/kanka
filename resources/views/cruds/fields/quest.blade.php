@if (!$campaign->enabled('quests'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->parent) {
    $preset = $model->parent;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\Quest::class);
}
@endphp

<x-forms.foreign
    :campaign="$campaign"
    name="quest_id"
    key="quest"
    entityType="quests"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.quest')] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Quest::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.quest')">
</x-forms.foreign>
