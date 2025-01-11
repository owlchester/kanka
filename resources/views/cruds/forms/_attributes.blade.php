<?php
/**
 * @var \App\Models\Attribute $attribute
 * @var \App\Models\AttributeTemplate $attributeTemplate
 */
$attributes = [];
if (isset($model)) {
    $attributes = $model->entity->attributes()->ordered()->get();
    $entity = $model->entity;
} elseif (isset($source)) {
    if (auth()->user()->can('view-attributes', [$source->entity, $campaign])) {
        $attributes = $source->entity->attributes()->ordered()->get();
        $entity = $source->entity;
    }
}
$isAdmin = Auth::user()->isAdmin();
$existingAttributeNames = [];
foreach ($attributes as $attribute) {
    $existingAttributeNames[] = $attribute->name;
}
?>
<x-grid type="1/1">

{{--<div id="entity-attributes-all">--}}
{{--    <div class="flex flex-col gap-2 entity-attributes sortable-elements" data-handle=".sortable-handler" id="add_attribute_target">--}}
{{--        @foreach ($attributes as $attribute)--}}
{{--            @if (!$attribute->is_hidden)--}}
{{--                @include('cruds.forms.attributes._attribute')--}}
{{--            @endif--}}
{{--        @endforeach--}}
{{--        @if (isset($entityAttributeTemplates))--}}
{{--            @foreach ($entityAttributeTemplates as $attributeTemplate)--}}
{{--                @include('cruds.forms.attributes._template')--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}
{{--<input type="hidden" name="save-attributes" value="1" />--}}

{{--@include('cruds.forms.attributes._blocks', ['existing' => count($attributes)])--}}
{{--@include('cruds.forms.attributes._buttons', ['model' => isset($entity) ? $entity->child : null, 'existing' => count($attributes)])--}}


    <div id="attributes-manager">
        @if (!empty($model))
            <attributes-manager api="{{ route('attributes.api-entity', [$campaign, $entity]) }}" />
        @elseif (!empty($source))
            <attributes-manager api="{{ route('attributes.api', [$campaign, 'entity_type' => $entityType->id, 'source' => $source->entity->id]) }}" />
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
