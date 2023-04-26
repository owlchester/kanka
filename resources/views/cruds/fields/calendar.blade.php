@if (!$campaignService->enabled('calendars'))
    <?php return ?>
@endif
<x-forms.foreign
    name="calendar_id"
    key="calendar"
    entityType="calendars"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('calendars.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Calendar::class"
    :selected="isset($model) && $model->calendar ? $model->calendar : FormCopy::field('calendar')->select(true, \App\Models\Calendar::class)"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null">
</x-forms.foreign>
