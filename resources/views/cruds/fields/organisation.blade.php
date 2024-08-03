@if (!$campaign->enabled('organisations'))
    <?php return ?>
@endif

@php
    $preset = null;
    if (isset($model) && $model->parent) {
        $preset = $model->parent;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('parent')->select($isParent ?? false, \App\Models\Organisation::class);
    }
@endphp
<x-forms.foreign
    :campaign="$campaign"
    name="organisation_id"
    key="organisation"
    entityType="organisations"
    :required="$required ?? false"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('organisations.find', [$campaign] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Organisation::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.organisation')">
</x-forms.foreign>
