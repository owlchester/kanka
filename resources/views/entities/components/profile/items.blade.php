<?php /** @var \App\Models\Item $model */?>

@if (!$entity->child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if ($entity->child->price)
        <div class="element profile-price">
            <div class="title text-uppercase text-xs">{{ __('items.fields.price') }}</div>
            {!! $entity->child->price !!}
        </div>
    @endif
    @if ($entity->child->size)
        <div class="element profile-size">
            <div class="title text-uppercase text-xs">{{ __('items.fields.size') }}</div>
            {!! $entity->child->size !!}
        </div>
    @endif

    @include('entities.components.profile._location')

    @if ($entity->child->character)
        <div class="element profile-character">
            <div class="title text-uppercase text-xs">{{ __('items.fields.character') }}</div>
            <x-entity-link
                :entity="$entity->child->character->entity"
                :campaign="$campaign" />
        </div>
    @endif


    @include('entities.components.profile._type')
</x-sidebar.profile>
