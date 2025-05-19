@php
    $preset = null;
    if (isset($model) && $model->parent) {
        $preset = $model->parent;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('parent')->child()->select($isParent ?? false, \App\Models\AttributeTemplate::class);
    }
@endphp
<x-forms.foreign
    :campaign="$campaign"
    name="attribute_template_id"
    key="attribute_template_id"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? true"
    :selected="$preset"
    :route="route('search-list', [$campaign, config('entities.ids.attribute_template')] + (isset($entity) ? ['exclude' => $entity->id] : []))"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.attribute_template')"
    :helper="__('attribute_templates.hints.parent_attribute_template')">
</x-forms.foreign>
