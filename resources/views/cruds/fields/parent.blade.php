@php
    $preset = null;
    if (isset($entity) && $entity instanceof \App\Models\Entity && $entity->parent) {
        $preset = $entity->parent;
    } elseif (isset($model) && $model instanceof \App\Models\Entity && $model->parent) {
        $preset = $model->parent;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('parent')->select(true, \App\Models\Entity::class);
    }
@endphp
<x-forms.foreign
    :campaign="$campaign"
    name="parent_id"
    key="parent_id"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? true"
    :selected="$preset"
    :route="route('search-list', [$campaign, $entityType, 'entity' => true] + (isset($entity) ? ['exclude' => $entity->id] : []))"
    :dropdownParent="$dropdownParent ?? null"
    :helper="__('crud.helpers.parent')"
    :entityTypeID="$entityType->id">
</x-forms.foreign>
