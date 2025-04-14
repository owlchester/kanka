@if (isset($required))
    @php $allowClear = false;@endphp
@endif
<x-forms.foreign
    :campaign="$campaign"
    :name="$name ?? 'template_id'"
    :key="$key ?? 'template'"
    :required="$required ?? false"
    :label="$label ?? null"
    :placeholder="$placeholder ?? null"
    :allowClear="$allowClear ?? true"
    :dynamicNew="$dynamicNew ?? false"
    :dynamicTag="$dynamicTag ?? null"
    :route="route($route ?? 'search.templates', [$campaign, $entityType])"
    :selected="$preset ?? null"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null">
</x-forms.foreign>
