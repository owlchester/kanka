@if (!$campaignService->enabled('timelines'))
    <?php return ?>
@endif
@php
    $preset = null;
    if (isset($model) && $model->timeline) {
        $preset = $model->timeline;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('timeline')->select($isParent ?? false, \App\Models\Timeline::class);
    }
@endphp
<x-forms.foreign
    name="timeline_id"
    key="timeline"
    entityType="timelines"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('timelines.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Timeline::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.timeline')">
</x-forms.foreign>
