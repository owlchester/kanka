@if (!isset($preset))
    @php
        $preset = null;
        if (isset($model) && $model->{$relation ?? 'entity'}) {
            $preset = $model->{$relation ?? 'entity'};
        } elseif (!isset($bulk)) {
            $preset = FormCopy::field($relation ?? 'entity')->child()->select($isParent ?? false, \App\Models\Entity::class);
        }
    @endphp
@endif
@if (isset($required))
    @php $allowClear = false;@endphp
@endif
<x-forms.foreign
    :campaign="$campaign"
    :name="$name ?? 'entity_id'"
    :key="$key ?? 'entity'"
    :required="$required ?? false"
    :label="$label ?? null"
    :placeholder="$placeholder ?? null"
    :allowClear="$allowClear ?? true"
    :route="route($route ?? 'search.entities-with-relations', [$campaign] + (isset($model) ? ['exclude' => $model->id] : []))"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null">
</x-forms.foreign>
