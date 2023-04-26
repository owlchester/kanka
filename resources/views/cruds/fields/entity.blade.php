@php
    $preset = null;
    if (isset($model) && $model->entity) {
        $preset = $model->entity;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('entity')->select($isParent ?? false, \App\Models\Entity::class);
    }
@endphp

<x-forms.foreign
    name="entity_id"
    key="entity"
    :required="$required ?? false"
    :label="$label ?? null"
    :allowClear="$allowClear ?? true"
    :route="route('search.entities-with-relations', isset($model) ? ['exclude' => $model->id] : null)"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null">
</x-forms.foreign>
