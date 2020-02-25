<?php
/**
 * @var Attribute $attribute
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

<div class="row">
    <div class="col-xs-4">{{ trans('crud.attributes.fields.attribute') }}</div>
    <div class="col-xs-4">{{ trans('crud.attributes.fields.value') }}</div>
    <div class="col-xs-1"><span class="hidden-xs">{{ trans('crud.attributes.fields.is_star') }}</span></div>
    @if ($isAdmin)<div class="col-xs-2"><span class="hidden-xs">{{ trans('crud.fields.is_private') }}</span></div>@endif
</div>
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
    <div id="add_unsortable_attribute_target"></div>
</div>

@include('cruds.forms.attributes._blocks', ['existing' => count($attributes)])
@include('cruds.forms.attributes._buttons', ['existing' => count($attributes)])

@section('scripts')
    @parent
    <script src="{{ mix('js/attributes.js') }}" defer></script>
@endsection
