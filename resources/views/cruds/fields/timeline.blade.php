@if (!$campaign->enabled('timelines'))
    <?php return ?>
@endif
@php
    $preset = null;
    if (isset($model) && $model->parent) {
        $preset = $model->parent;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('parent')->select($isParent ?? false, \App\Models\Timeline::class);
    }
@endphp
<x-forms.foreign
    :campaign="$campaign"
    name="timeline_id"
    key="timeline"
    entityType="timelines"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('timelines.find', [$campaign] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Timeline::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.timeline')">
</x-forms.foreign>
