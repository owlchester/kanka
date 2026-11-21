<?php
/**
 * @var \App\Models\Attribute $attribute
 * @var \App\Models\AttributeTemplate $attributeTemplate
 */
if (isset($model)) {
    $entity = $model->entity;
} elseif (isset($source)) {
    if ($source instanceof \App\Models\Entity) {
        if (auth()->user()->can('attributes', [$source])) {
            $entity = $source;
        }
    }
    elseif (auth()->user()->can('view-attributes', [$source->entity, $campaign])) {
        $entity = $source->entity;
    }
}

if (! empty($entity)) {
    $attributesApi = route('attributes.api-entity', [$campaign, $entity]);
} elseif (! empty($source)) {
    $attributesApi = route('attributes.api', [$campaign, 'entity_type' => $entityType->id, 'source' => $entity->id]);
} else {
    $attributesApi = route('attributes.api', [$campaign, 'entity_type' => $entityType->id]);
}
?>
<x-grid type="1/1">
    <div id="attributes-manager" data-api="{{ $attributesApi }}"></div>
</x-grid>
@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
    @vite('resources/js/attributes-manager.js')
@endsection
