<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Item $model
 */
$child = $entity->child;
?>
@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if ($child->price)
        <div class="element profile-price">
            <div class="title text-uppercase text-xs">{{ __('items.fields.price') }}</div>
            {!! $child->price !!}
        </div>
    @endif
    @if ($child->size)
        <div class="element profile-size">
            <div class="title text-uppercase text-xs">{{ __('items.fields.size') }}</div>
            {!! $child->size !!}
        </div>
    @endif

    @include('entities.components.profile._location')

    @if ($child->character)
        <div class="element profile-character">
            <div class="title text-uppercase text-xs">{{ __('items.fields.character') }}</div>
            <x-entity-link
                :entity="$child->character->entity"
                :campaign="$campaign" />
        </div>
    @endif


    @include('entities.components.profile._type')
</x-sidebar.profile>
