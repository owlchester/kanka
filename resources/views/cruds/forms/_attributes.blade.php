<?php
/**
 * @var \App\Models\Attribute $attribute
 * @var \App\Models\AttributeTemplate $attributeTemplate
 */
$attributes = [];
if (isset($model)) {
    $attributes = $model->entity->attributes()->ordered()->get();
} elseif (isset($source)) {
    $attributes = $source->entity->attributes()->ordered()->get();
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
            @include('cruds.forms.attributes._attribute')
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
@include('cruds.forms.attributes._buttons', ['existing' => count($attributes)])

@section('scripts')
    @parent
    <script src="{{ mix('js/attributes.js') }}" defer></script>
@endsection
