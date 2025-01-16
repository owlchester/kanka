@if (!$campaign->enabled('events'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->parent) {
    $preset = $model->parent;
} elseif (!isset($bulk)) {
    $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\Event::class);
}
@endphp

<x-forms.foreign
    :campaign="$campaign"
    name="event_id"
    key="event"
    entityType="events"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.event')] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Event::class"
    :selected="$preset"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.event')">
</x-forms.foreign>
