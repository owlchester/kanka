@if (!$campaign->enabled('calendars'))
    <?php return ?>
@endif

@if (!isset($preset))
@php
    $preset = null;
    if (isset($model) && $model->calendar) {
        $preset = $model->calendar;
    } elseif (isset($model) && $model->parent) {
        $preset = $model->parent;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\Calendar::class);
    }
@endphp
@endif
<x-forms.foreign
    :campaign="$campaign"
    name="calendar_id"
    key="calendar"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :dynamicNew="$dynamicNew ?? false"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.calendar')] + (isset($entity) ? ['exclude' => $entity->id] : []))"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.calendar')">
</x-forms.foreign>
