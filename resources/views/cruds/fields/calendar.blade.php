@if (!$campaignService->enabled('calendars'))
    <?php return ?>
@endif

@if (!isset($preset))
@php
    $preset = null;
    if (isset($model) && $model->calendar) {
        $preset = $model->calendar;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('calendar')->select($isParent ?? false, \App\Models\Calendar::class);
    }
@endphp
@endif
<x-forms.foreign
    :name="$name ?? calendar_id"
    key="calendar"
    entityType="calendars"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('calendars.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Calendar::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.calendar')">
</x-forms.foreign>
