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
    @includeWhen($entity->aliases->isNotEmpty(), 'entities.components.profile._aliases')
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

    @if ($child->weight)
        <div class="element profile-weight">
            <div class="title text-uppercase text-xs">{{ __('items.fields.weight') }}</div>
            {!! $child->weight !!}
        </div>
    @endif

    @include('entities.components.profile._location')

    @if ($child->itemCreators->isNotEmpty())
        <div class="element profile-creator">
            <div class="title text-uppercase text-xs">{{ __('items.fields.creators') }}</div>
            @foreach ($child->itemCreators as $itemCreator)
                <span class="element">
                    <x-entity-link
                        :entity="$itemCreator->creator"
                        :campaign="$campaign" />
                </span>
            @endforeach
        </div>
    @endif


    @include('entities.components.profile._type')
</x-sidebar.profile>
