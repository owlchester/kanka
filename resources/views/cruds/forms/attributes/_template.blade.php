<?php
/**
 * @var \App\Models\AttributeTemplate $attributeTemplate
 */
?>
@if ($attributeTemplate->hasVisibleAttributes($existingAttributeNames))
    <p class="help-block">
        {!! __('attribute_templates.hints.automatic', [
            'link' => link_to($attributeTemplate->getLink(), e($attributeTemplate->name))
        ]) !!}
    </p>
    @foreach ($attributeTemplate->entity->attributes()->ordered()->get() as $attribute)
        @if (!in_array($attribute->name, $existingAttributeNames))
            @include('cruds.forms.attributes._attribute', ['resetAttributeId' => true])
        @endif
    @endforeach
@endif
