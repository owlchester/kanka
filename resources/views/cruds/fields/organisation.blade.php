@if (!$campaign->enabled('organisations'))
    <?php return ?>
@endif

@php
    $field = isset($isParent) && $isParent ? 'parent' : 'organisation';
    $preset = null;
    if (isset($model) && $model->$field) {
        $preset = $model->$field;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field($field)->child()->select($isParent ?? false, \App\Models\Organisation::class);
    }
@endphp
<x-forms.foreign
    :campaign="$campaign"
    name="organisation_id"
    key="organisation"
    :required="$required ?? false"
    :allowNew="$allowNew ?? true"
    :dynamicNew="$dynamicNew ?? false"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('search-list', [$campaign, config('entities.ids.organisation')] + (isset($entity) ? ['exclude' => $entity->id] : []))"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.organisation')">
</x-forms.foreign>
