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
    $attributes = $source->entity->attributes()->ordered()->get();
    $entity = $source->entity;
}
$isAdmin = Auth::user()->isAdmin();
$existingAttributeNames = [];
foreach ($attributes as $attribute) {
    $existingAttributeNames[] = $attribute->name;
}
?>

@include('cruds.fields.attribute_template')

<div id="entity-attributes-all">
    <div class="entity-attributes">
        @foreach ($attributes as $attribute)
            @if (!$attribute->is_hidden)
                @include('cruds.forms.attributes._attribute')
            @endif
        @endforeach
        @if (isset($entityAttributeTemplates))
            @foreach ($entityAttributeTemplates as $attributeTemplate)
                @include('cruds.forms.attributes._template')
            @endforeach
        @endif
        <div id="add_attribute_target"></div>
    </div>
</div>
<input type="hidden" name="save-attributes" value="1" />

@include('cruds.forms.attributes._blocks', ['existing' => count($attributes)])
@include('cruds.forms.attributes._buttons', ['model' => isset($entity) ? $entity->child : null, 'existing' => count($attributes)])

@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
@endsection
