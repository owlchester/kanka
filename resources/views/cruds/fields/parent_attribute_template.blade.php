<x-forms.foreign
    name="attribute_template_id"
    key="attribute_template_id"
    entityType="attribute_templates"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route('attribute_templates.find')"
    :class="\App\Models\AttributeTemplate::class"
    :dropdownParent="$dropdownParent ?? null"
    :helper="__('attribute_templates.hints.parent_attribute_template')">
</x-forms.foreign>
