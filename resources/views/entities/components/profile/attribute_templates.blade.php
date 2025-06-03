<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\AttributeTemplate $model
 */
$child = $entity->child;
?>
@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($child->attributeTemplate))
        <div class="element profile-attribute-template">
            <div class="title text-uppercase text-xs">{{ __('crud.fields.parent') }}</div>
            <x-entity-link
                :entity="$child->attributeTemplate->entity"
                :campaign="$campaign" />
        </div>
    @endif

    <div class="element profile-is-enabled">
        <div class="title text-uppercase text-xs">{{ __('attribute_templates.fields.is_enabled') }}</div>
        @if ($child->is_enabled)
            {{ __('general.yes')}}
        @else
            {{ __('general.no')}}
        @endif
    </div>

    @if (!empty($child->entityType))
        <div class="element profile-entity-type">
            <div class="title text-uppercase text-xs">{{ __('attribute_templates.fields.auto_apply') }}</div>
            {!! $child->entityType->name() !!}
        </div>
    @endif
</x-sidebar.profile>
