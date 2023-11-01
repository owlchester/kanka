@php
    $preset = null;
    if (isset($model) && $model->attributeTemplate) {
        $preset = $model->attributeTemplate;
    } elseif (!isset($bulk)) {
        $preset = FormCopy::field('attribute_template')->select($isParent ?? false, \App\Models\AttributeTemplate::class);
    }
@endphp
<x-forms.foreign
    :campaign="$campaign"
    name="attribute_template_id"
    key="attribute_template_id"
    entityType="attribute_templates"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? true"
    :selected="$preset"
    :route="route('attribute_templates.find', $campaign)"
    :class="\App\Models\AttributeTemplate::class"
    :dropdownParent="$dropdownParent ?? null"
    :helper="__('attribute_templates.hints.parent_attribute_template')">
</x-forms.foreign>
