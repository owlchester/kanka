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
?>
<x-grid type="1/1">
    <div id="attributes-manager">
        @if (!empty($entity))
            <attributes-manager api="{{ route('attributes.api-entity', [$campaign, $entity]) }}" />
        @elseif (!empty($source))
            <attributes-manager api="{{ route('attributes.api', [$campaign, 'entity_type' => $entityType->id, 'source' => $entity->id]) }}" />
        @else
            <attributes-manager api="{{ route('attributes.api', [$campaign, 'entity_type' => $entityType->id]) }}" />
        @endif
    </div>
</x-grid>
@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
    @vite('resources/js/attributes-manager.js')
@endsection
