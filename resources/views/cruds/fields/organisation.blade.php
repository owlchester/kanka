@if (!$campaignService->enabled('organisations'))
    <?php return ?>
@endif

@php
    $preset = null;
    if (isset($model) && $model->organisation) {
        $preset = $model->organisation;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('organisation')->select($isParent ?? false, \App\Models\Organisation::class);
    }
@endphp
<x-forms.foreign
    name="organisation_id"
    key="organisation"
    entityType="organisations"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('organisations.find', isset($model) ? ['exclude' => $model->id] : null)"
    :class="\App\Models\Organisation::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null">
</x-forms.foreign>
