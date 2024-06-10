<?php
/**
 * @var \App\Models\AttributeTemplate $attributeTemplate
 */
?>
@if ($attributeTemplate->hasVisibleAttributes($existingAttributeNames))
    <p class="text-neutral-content m-0">
        {!! __('attribute_templates.hints.automatic', [
            'link' => '<a href="' . $attributeTemplate->getLink() . '">' . $attributeTemplate->name . '</a>'
        ]) !!}
    </p>
    @foreach ($attributeTemplate->entity->attributes()->ordered()->get() as $attribute)
        @if (!in_array($attribute->name, $existingAttributeNames))
            @include('cruds.forms.attributes._attribute', ['resetAttributeId' => true])
        @endif
    @endforeach
@endif
